<?php

declare(strict_types=1);

namespace App\Enums;

enum Permissions: string
{
    case ShowUsers = 'show users';
    case EditUsers = 'edit users';
    case CreateUsers = 'create users';
    case DeleteUsers = 'delete users';

    case ShowRoles = 'show roles';
    case EditRoles = 'edit roles';
    case CreateRoles = 'create roles';
    case DeleteRoles = 'delete roles';
    case ShowSuggestions = 'show suggestions';
    case EditSuggestions = 'edit suggestions';
    case CreateSuggestions = 'create suggestions';
    case DeleteSuggestions = 'delete suggestions';
    case AssignRoles = 'assign roles';
    case AssignPermissions = 'assign permissions';

    public function getName(): string
    {
        return match ($this) {
            self::ShowUsers => 'Просмотр пользователей',
            self::EditUsers => 'Редактирование пользователей',
            self::CreateUsers => 'Создание пользователей',
            self::DeleteUsers => 'Удаление пользователей',
            self::ShowRoles => 'Просмотр ролей',
            self::EditRoles => 'Редактирование ролей',
            self::CreateRoles => 'Создание ролей',
            self::DeleteRoles => 'Удаление ролей',
            self::ShowSuggestions => 'Просмотр предложений',
            self::EditSuggestions => 'Редактирование предложений',
            self::CreateSuggestions => 'Создание предложений',
            self::DeleteSuggestions => 'Удаление предложений',
            self::AssignRoles => 'Назначение ролей',
            self::AssignPermissions => 'Назначение прав',
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
