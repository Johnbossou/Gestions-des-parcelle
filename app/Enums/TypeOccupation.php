<?php

namespace App\Enums;

enum TypeOccupation: string
{
    case AUTORISE = 'Autorisé';
    case ANARCHIQUE = 'Anarchique';
    case LIBRE = 'Libre';

    public function couleur(): string
    {
        return match($this) {
            self::AUTORISE => '#38A169',
            self::ANARCHIQUE => '#E30613',
            self::LIBRE => '#3182CE',
        };
    }

    public function icone(): string
    {
        return match($this) {
            self::AUTORISE => '✅',
            self::ANARCHIQUE => '⚠️',
            self::LIBRE => '📋',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::AUTORISE => 'Occupation légale et autorisée par les autorités compétentes',
            self::ANARCHIQUE => 'Occupation non autorisée ou illégale nécessitant une régularisation',
            self::LIBRE => 'Parcelle libre et disponible pour attribution',
        };
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function names(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }

    public static function labels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->value;
        }
        return $labels;
    }

    public function label(): string
    {
        return $this->value;
    }
}
