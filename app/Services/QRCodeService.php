<?php

namespace App\Services;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
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

        // Create QR code writer with SVG renderer
        $writer = new Writer(
            new \BaconQrCode\Renderer\ImageRenderer(
                new RendererStyle(300),
                new SvgImageBackEnd()
            )
        );
        
        // Generate QR code as SVG string
        $qrCodeSvg = $writer->writeString($qrData);

        // Save to storage
        $filename = 'qr-codes/user-' . $userId . '-' . time() . '.svg';
        Storage::disk('public')->put($filename, $qrCodeSvg);

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
