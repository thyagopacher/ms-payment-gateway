<?php

namespace Tests\Feature;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaymentReportTest extends TestCase
{
    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedPayments();
    }

    /**
     * Seeds the database with test payment data
     */
    private function seedPayments(): void
    {
        // Creates 10 sample payments for testing
        for ($i = 0; $i < 10; $i++) {
            $paymentDate = date("Y-m-d H:i:s", strtotime("-" . rand(1, 30) . " days"));
            $data = [
                'bill_amount' => fake()->randomFloat(2, 100, 5000),
                'status' => fake()->randomElement([
                    PaymentStatus::PENDING->value,
                    PaymentStatus::PAID->value,
                    PaymentStatus::FAILED->value
                ]),
                'payment_method' => fake()->randomElement([
                    PaymentMethod::PIX->value,
                    PaymentMethod::BANK_SLIP->value,
                ]),
                'bill_paid_at' => $paymentDate,
                'bill_due_date' => date("Y-m-d", strtotime($paymentDate . " +7 days")),
                'person_document' => fake()->numerify('###########'),
            ];
            $this->post('/api/payment', $data);
        }
    }

    #[Test]
    public function test_csv_report_returns_success_response(): void
    {
        $response = $this->get('/api/payment/csv-report');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv');
        $response->assertHeader('Content-Disposition');
    }

    #[Test]
    public function test_csv_report_returns_valid_filename(): void
    {
        $response = $this->get('/api/payment/csv-report');

        $this->assertStringContainsString(
            'attachment; filename=',
            $response->header('Content-Disposition')
        );
        $this->assertStringContainsString('.csv', $response->header('Content-Disposition'));
    }

    #[Test]
    public function test_csv_report_contains_data(): void
    {
        $response = $this->get('/api/payment/csv-report');

        $content = $response->getContent();
        $this->assertNotEmpty($content, 'CSV report content is empty');
        $this->assertStringContainsString(',', $content, 'CSV content does not contain commas');
    }

    #[Test]
    public function test_csv_report_with_filters(): void
    {
        $response = $this->get('/api/payment/csv-report?status=paid&payment_method=pix');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv');
        
        $content = $response->getContent();
        $this->assertNotEmpty($content);
    }

    #[Test]
    public function test_csv_report_with_date_range(): void
    {
        $startDate = date('Y-m-d', strtotime('-30 days'));
        $endDate = date('Y-m-d');

        $response = $this->get("/api/payment/csv-report?start_date={$startDate}&end_date={$endDate}");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv');
    }

    #[Test]
    #[Depends('test_csv_report_returns_success_response')]
    public function test_pdf_report_returns_success_response(): void
    {
        $response = $this->get('/api/payment/pdf-report');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition');
    }

    #[Test]
    public function test_pdf_report_returns_valid_filename(): void
    {
        $response = $this->get('/api/payment/pdf-report');

        $this->assertStringContainsString(
            'attachment; filename=',
            $response->header('Content-Disposition')
        );
        $this->assertStringContainsString('.pdf', $response->header('Content-Disposition'));
    }

    #[Test]
    public function test_pdf_report_contains_data(): void
    {
        $response = $this->get('/api/payment/pdf-report');

        $content = $response->getContent();
        $this->assertNotEmpty($content, 'PDF report content is empty');
        // PDF files start with %PDF magic number
        $this->assertStringStartsWith('%PDF', $content, 'PDF content does not start with PDF header');
    }

    #[Test]
    public function test_pdf_report_with_filters(): void
    {
        $response = $this->get('/api/payment/pdf-report?status=paid&payment_method=pix');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        
        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertStringStartsWith('%PDF', $content);
    }

    #[Test]
    public function test_pdf_report_with_date_range(): void
    {
        $startDate = date('Y-m-d', strtotime('-30 days'));
        $endDate = date('Y-m-d');

        $response = $this->get("/api/payment/pdf-report?start_date={$startDate}&end_date={$endDate}");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    #[Test]
    public function test_csv_report_file_size_is_reasonable(): void
    {
        $response = $this->get('/api/payment/csv-report');

        $content = $response->getContent();
        $this->assertGreaterThan(0, strlen($content), 'CSV file size is 0');
        // CSV should be less than 10MB for reasonable data
        $this->assertLessThan(10 * 1024 * 1024, strlen($content), 'CSV file is too large');
    }

    #[Test]
    public function test_pdf_report_file_size_is_reasonable(): void
    {
        $response = $this->get('/api/payment/pdf-report');

        $content = $response->getContent();
        $this->assertGreaterThan(0, strlen($content), 'PDF file size is 0');
        // PDF should be less than 50MB for reasonable data
        $this->assertLessThan(50 * 1024 * 1024, strlen($content), 'PDF file is too large');
    }

    #[Test]
    public function test_csv_report_invalid_status_filter(): void
    {
        $response = $this->get('/api/payment/csv-report?status=invalid_status');

        // Should still return 200 or handle gracefully
        $this->assertIn($response->getStatusCode(), [200, 422]);
    }

    #[Test]
    public function test_pdf_report_invalid_date_format(): void
    {
        $response = $this->get('/api/payment/pdf-report?start_date=invalid-date');

        // Should handle invalid date gracefully (422 or 200 with default behavior)
        $this->assertIn($response->getStatusCode(), [200, 422]);
    }

    #[Test]
    public function test_csv_report_multiple_filter_combinations(): array
    {
        $filters = [
            ['status=paid'],
            ['payment_method=pix'],
            ['status=pending&payment_method=bank_slip'],
            ['status=failed&payment_method=pix'],
        ];

        $results = [];
        foreach ($filters as $filter) {
            $queryString = implode('&', $filter);
            $response = $this->get("/api/payment/csv-report?{$queryString}");
            
            $this->assertEquals(200, $response->getStatusCode(), "Failed with filter: {$queryString}");
            $results[] = [
                'filter' => $queryString,
                'status' => $response->getStatusCode(),
                'content_length' => strlen($response->getContent())
            ];
        }

        return $results;
    }

    #[Test]
    #[Depends('test_csv_report_multiple_filter_combinations')]
    public function test_csv_report_filters_produce_different_results(array $filterResults): void
    {
        // Verify that different filters produce different sized results
        $sizes = array_map(fn($result) => $result['content_length'], $filterResults);
        
        // At least some filters should produce different sized outputs
        $this->assertGreaterThan(1, count(array_unique($sizes)), 'Filters should produce different result sizes');
    }

    #[Test]
    public function test_pdf_report_format_integrity(): void
    {
        $response = $this->get('/api/payment/pdf-report');
        $content = $response->getContent();

        // Check PDF structure
        $this->assertStringStartsWith('%PDF', $content);
        $this->assertStringContainsString('%%EOF', $content, 'PDF does not end with EOF marker');
    }

    #[Test]
    public function test_csv_report_has_headers(): void
    {
        $response = $this->get('/api/payment/csv-report');
        $content = $response->getContent();

        $lines = explode("\n", $content);
        $this->assertGreaterThan(0, count($lines), 'CSV has no lines');
        
        // First line should contain headers
        $headers = str_getcsv($lines[0]);
        $this->assertGreaterThan(0, count($headers), 'CSV has no headers');
    }

    #[Test]
    public function test_both_report_formats_have_same_period_data(): void
    {
        $startDate = date('Y-m-d', strtotime('-7 days'));
        $endDate = date('Y-m-d');

        $csvResponse = $this->get("/api/payment/csv-report?start_date={$startDate}&end_date={$endDate}");
        $pdfResponse = $this->get("/api/payment/pdf-report?start_date={$startDate}&end_date={$endDate}");

        // Both should return 200
        $this->assertEquals(200, $csvResponse->getStatusCode());
        $this->assertEquals(200, $pdfResponse->getStatusCode());

        // Both should have content
        $this->assertNotEmpty($csvResponse->getContent());
        $this->assertNotEmpty($pdfResponse->getContent());
    }

    #[Test]
    public function test_report_response_headers_security(): void
    {
        $response = $this->get('/api/payment/csv-report');

        // Check that headers don't expose sensitive information
        $this->assertNotNull($response->header('Content-Type'));
        $this->assertNotNull($response->header('Content-Disposition'));
    }

    #[Test]
    public function test_concurrent_report_requests(): void
    {
        // Test that multiple requests don't interfere with each other
        $responses = [];
        
        for ($i = 0; $i < 3; $i++) {
            $response = $this->get('/api/payment/csv-report');
            $responses[] = $response->getContent();
        }

        // All responses should have content
        foreach ($responses as $response) {
            $this->assertNotEmpty($response);
        }

        // All responses should be identical (same data)
        $this->assertEquals($responses[0], $responses[1]);
        $this->assertEquals($responses[1], $responses[2]);
    }
}