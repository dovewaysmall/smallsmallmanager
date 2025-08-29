<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UnioneEmailService
{
    private $apiUrl = 'https://eu1.unione.io/ru/transactional/api/v1';
    private $username = 'tunde.b@smallsmall.com';
    private $apiKey = 'player2023';

    public function sendInspectionDateChangeNotification($inspectionId, $oldDate, $newDate, $inspectionDetails = [])
    {
        try {
            $subject = "Inspection Date Updated - ID: {$inspectionId}";
            $htmlBody = $this->buildInspectionDateChangeEmail($inspectionId, $oldDate, $newDate, $inspectionDetails);
            
            return $this->sendEmail('dikcondtn@yahoo.com', $subject, $htmlBody);
        } catch (\Exception $e) {
            Log::error('Failed to send inspection date change notification: ' . $e->getMessage());
            return false;
        }
    }

    private function buildInspectionDateChangeEmail($inspectionId, $oldDate, $newDate, $details)
    {
        $propertyInfo = $details['property'] ?? 'N/A';
        $assignedTsr = $details['assigned_tsr'] ?? 'N/A';
        $status = $details['inspection_status'] ?? 'N/A';

        return "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background-color: #f8f9fa; }
                .highlight { background-color: #fff3cd; padding: 10px; border-left: 4px solid #ffc107; margin: 10px 0; }
                .table { width: 100%; border-collapse: collapse; margin: 15px 0; }
                .table td { padding: 8px; border: 1px solid #ddd; }
                .table td:first-child { font-weight: bold; background-color: #e9ecef; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Inspection Date Change Notification</h2>
                </div>
                <div class='content'>
                    <p>This is to notify you that an inspection date has been updated in the SmallSmall Manager system.</p>
                    
                    <div class='highlight'>
                        <strong>Inspection ID:</strong> {$inspectionId}
                    </div>
                    
                    <table class='table'>
                        <tr><td>Previous Date</td><td>{$oldDate}</td></tr>
                        <tr><td>New Date</td><td>{$newDate}</td></tr>
                        <tr><td>Property</td><td>{$propertyInfo}</td></tr>
                        <tr><td>Assigned TSR</td><td>{$assignedTsr}</td></tr>
                        <tr><td>Status</td><td>{$status}</td></tr>
                        <tr><td>Updated At</td><td>" . now()->format('Y-m-d H:i:s') . "</td></tr>
                    </table>
                    
                    <p>Please review this change and take any necessary actions.</p>
                    
                    <hr>
                    <p><small>This is an automated notification from SmallSmall Manager.</small></p>
                </div>
            </div>
        </body>
        </html>
        ";
    }

    public function sendEmail($to, $subject, $htmlBody, $fromName = 'SmallSmall Manager')
    {
        try {
            $data = [
                'message' => [
                    'recipients' => [
                        [
                            'email' => $to,
                            'substitutions' => []
                        ]
                    ],
                    'body' => [
                        'html' => $htmlBody
                    ],
                    'subject' => $subject,
                    'from_email' => $this->username,
                    'from_name' => $fromName
                ]
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-API-KEY' => $this->apiKey
                ])
                ->post($this->apiUrl . '/email/send.json', $data);

            Log::info('Unione API Response Status: ' . $response->status());
            Log::info('Unione API Response Body: ' . $response->body());

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['status']) && $responseData['status'] === 'success') {
                    Log::info("Email sent successfully to {$to}");
                    return true;
                } else {
                    Log::error('Unione API returned non-success status: ' . json_encode($responseData));
                    return false;
                }
            } else {
                Log::error('Unione API request failed with status: ' . $response->status());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Email sending error: ' . $e->getMessage());
            return false;
        }
    }
}