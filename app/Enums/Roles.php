<?php

declare(strict_types=1);

namespace App\Enums;

enum Roles: string
{
    case Root = 'root';
    case Admin = 'admin';
    case Manager = 'manager';
    case Curator = 'curator';
    case Economist = 'economist';
    case User = 'user';

    public function getName(): string
    {
        return match ($this) {
            self::Root => 'Супер-админ',
            self::Admin => 'Админ',
            self::Manager => 'Менеджер',
            self::Curator => 'Куратор',
            self::Economist => 'Экономист',
            self::User => 'Пользователь',
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
