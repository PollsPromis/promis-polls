<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {

        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id'); // permission id
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('title');
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('title');
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
            $table->unsignedBigInteger($pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
            $table->unsignedBigInteger($pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));



        // Миграция для таблицы 'types'
        Schema::create('types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
        });

        // Миграция для таблицы 'statuses'
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
        });

        // Миграция для таблицы 'departments'
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
        });

        // Миграция для таблицы 'posts'
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
        });

        // Миграция для таблицы 'economic_indicators'
        Schema::create('economic_indicators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('measurable_indicator_before');
            $table->integer('measurable_indicator_after');
            $table->float('economic_effect');
            $table->float('expenses');
            $table->float('payments_to_authors');
            $table->float('payments_to_implementers');
        });

        // Миграция для таблицы 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('email')->unique();
            $table->string('login')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });

        // Миграция для таблицы 'suggestions'
        Schema::create('suggestions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date');
            $table->string('author');
            $table->string('collaborator');
            $table->string('email')->nullable();
            $table->bigInteger('phone_number')->nullable();
            $table->unsignedBigInteger('depart_id');
            $table->unsignedBigInteger('type_id');
            $table->text('suggestion_content');
            $table->unsignedBigInteger('economic_indic_id')->nullable();
            $table->boolean('sent_for_expertise')->default(false);
            $table->text('manager_comment')->nullable();
            $table->boolean('does_solve_a_problem')->default(false);
            $table->string('realizer')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('depart_id')->references('id')->on('departments');
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('economic_indic_id')->references('id')->on('economic_indicators');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        // Миграция для таблицы 'suggestion_images_before'
        Schema::create('sugg_images_before', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_path');
            $table->unsignedBigInteger('sugg_id');

            $table->foreign('sugg_id')->references('id')->on('suggestions')->onDelete('cascade');
        });

        // Миграция для таблицы 'suggestion_images_after'
        Schema::create('sugg_images_after', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_path');
            $table->unsignedBigInteger('sugg_id');

            $table->foreign('sugg_id')->references('id')->on('suggestions')->onDelete('cascade');
        });

        // Миграция для таблицы 'user_suggestions'
        Schema::create('user_suggestions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sugg_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sugg_id')->references('id')->on('suggestions')->onDelete('cascade');
        });

        // Миграция для таблицы 'suggestion_posts'
        Schema::create('suggestion_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sugg_id');
            $table->unsignedBigInteger('post_id');

            $table->foreign('sugg_id')->references('id')->on('suggestions')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });


    }

    public function down()
    {
        Schema::drop('role_has_permissions');
        Schema::drop('model_has_roles');
        Schema::drop('model_has_permissions');
        Schema::drop('roles');
        Schema::drop('permissions');


        Schema::dropIfExists('statuses');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('economic_indicators');
        Schema::dropIfExists('users');
        Schema::dropIfExists('suggestions');
        Schema::dropIfExists('sugg_images_before');
        Schema::dropIfExists('sugg_images_after');
        Schema::dropIfExists('user_suggestions');
        Schema::dropIfExists('suggestion_posts');
    }
}
