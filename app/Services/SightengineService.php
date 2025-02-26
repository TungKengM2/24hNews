<?php

namespace App\Services;

use Exception;
use Sightengine\SightengineClient;

class SightengineService
{
    protected $client;

    public function __construct()
    {
        $this->client = new SightengineClient(
            config('services.sightengine.user'),
            config('services.sightengine.secret')
        );
    }

    public function checkTextContent(string $content)
    {
        try {
            $response = $this->client->check(['text'])->set_text($content);

            return [
                'is_approved' => $response->profanity <= 0.5 && $response->status === 'success',
                'profanity_score' => $response->profanity,
                'raw_response' => $response,
            ];
        } catch (Exception $e) {
            return [
                'is_approved' => false,
                'error' => 'Text moderation service unavailable',
            ];
        }
    }

    public function checkImageContent(string $imagePath)
    {
        try {
            $response = $this->client->check([
                'nudity',
                'wad',
                'weapons',
                'drugs',
            ])->set_file($imagePath);

            return [
                'is_approved' => $response->nudity->raw <= 0.5 &&
                    $response->weapons <= 0.5 &&
                    $response->drugs <= 0.5 &&
                    $response->status === 'success',
                'nudity_score' => $response->nudity->raw,
                'weapons_score' => $response->weapons,
                'drugs_score' => $response->drugs,
                'raw_response' => $response,
            ];
        } catch (Exception $e) {
            return [
                'is_approved' => false,
                'error' => 'Image moderation service unavailable',
            ];
        }
    }
}
