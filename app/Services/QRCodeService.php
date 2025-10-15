<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    /**
     * Generate QR code for a user
     *
     * @param int $userId
     * @param string $fullName
     * @param string $nationalId
     * @return string Path to QR code
     */
    public function generateUserQRCode($userId, $fullName, $nationalId): string
    {
        $qrData = json_encode([
            'user_id' => $userId,
            'name' => $fullName,
            'national_id' => $nationalId,
            'type' => 'citizen_verification',
            'generated_at' => now()->toIso8601String(),
        ]);

        $qrCode = QrCode::create($qrData)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Save to storage
        $filename = 'qr-codes/user-' . $userId . '-' . time() . '.png';
        Storage::disk('public')->put($filename, $result->getString());

        return $filename;
    }

    /**
     * Get the full URL for a QR code
     *
     * @param string $path
     * @return string
     */
    public function getQRCodeUrl($path): string
    {
        return Storage::disk('public')->url($path);
    }
}
