<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateUsersTable extends Migration
    {
        public function up()
        {

            // Миграция для таблицы 'roles'
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('role_id');
                $table->string('title');
            });

            // Миграция для таблицы 'types'
            Schema::create('types', function (Blueprint $table) {
                $table->bigIncrements('type_id');
                $table->string('title');
            });

            // Миграция для таблицы 'statuses'
            Schema::create('statuses', function (Blueprint $table) {
                $table->bigIncrements('status_id');
                $table->string('title');
            });

            // Миграция для таблицы 'departments'
            Schema::create('departments', function (Blueprint $table) {
                $table->bigIncrements('depart_id');
                $table->string('title');
            });

            // Миграция для таблицы 'posts'
            Schema::create('posts', function (Blueprint $table) {
                $table->bigIncrements('post_id');
                $table->string('title');
            });

            // Миграция для таблицы 'economic_indicators'
            Schema::create('economic_indicators', function (Blueprint $table) {
                $table->bigIncrements('economic_indic_id');
                $table->integer('measurable_indicator_before');
                $table->integer('measurable_indicator_after');
                $table->float('economic_effect');
                $table->float('expenses');
                $table->float('payments_to_authors');
                $table->float('payments_to_implementers');
            });

            // Миграция для таблицы 'users'
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('user_id');
                $table->string('first_name');
                $table->string('second_name');
                $table->string('email')->unique();
                $table->string('login')->unique();
                $table->string('password');
                $table->unsignedBigInteger('role_id');
                $table->timestamps();

                $table->foreign('role_id')->references('role_id')->on('roles');
            });

            // Миграция для таблицы 'suggestions'
            Schema::create('suggestions', function (Blueprint $table) {
                $table->bigIncrements('sugg_id');
                $table->timestamp('date');
                $table->string('author');
                $table->string('collaborator');
                $table->string('email');
                $table->bigInteger('phone_number')->nullable();
                $table->unsignedBigInteger('depart_id');
                $table->unsignedBigInteger('type_id');
                $table->text('suggestion_content');
                $table->unsignedBigInteger('economic_indic_id');
                $table->boolean('sent_for_expertise')->default(false);
                $table->text('manager_comment')->nullable();
                $table->boolean('does_solve_a_problem')->default(false);
                $table->string('realizer')->nullable();
                $table->unsignedBigInteger('status_id');
                $table->timestamps();

                $table->foreign('depart_id')->references('depart_id')->on('departments');
                $table->foreign('type_id')->references('type_id')->on('types');
                $table->foreign('economic_indic_id')->references('economic_indic_id')->on('economic_indicators');
                $table->foreign('status_id')->references('status_id')->on('statuses');
            });

            // Миграция для таблицы 'suggestion_images_before'
            Schema::create('sugg_images_before', function (Blueprint $table) {
                $table->bigIncrements('sugg_images_id');
                $table->string('file_path');
                $table->unsignedBigInteger('sugg_id');

                $table->foreign('sugg_id')->references('sugg_id')->on('suggestions')->onDelete('cascade');
            });

            // Миграция для таблицы 'suggestion_images_after'
            Schema::create('sugg_images_after', function (Blueprint $table) {
                $table->bigIncrements('sugg_images_id');
                $table->string('file_path');
                $table->unsignedBigInteger('sugg_id');

                $table->foreign('sugg_id')->references('sugg_id')->on('suggestions')->onDelete('cascade');
            });

            // Миграция для таблицы 'user_suggestions'
            Schema::create('user_suggestions', function (Blueprint $table) {
                $table->bigIncrements('user_sugg_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('sugg_id');

                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
                $table->foreign('sugg_id')->references('sugg_id')->on('suggestions')->onDelete('cascade');
            });

            // Миграция для таблицы 'suggestion_posts'
            Schema::create('suggestion_posts', function (Blueprint $table) {
                $table->bigIncrements('sugg_posts_id');
                $table->unsignedBigInteger('sugg_id');
                $table->unsignedBigInteger('post_id');

                $table->foreign('sugg_id')->references('sugg_id')->on('suggestions')->onDelete('cascade');
                $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            });



        }

        public function down()
        {
            Schema::dropIfExists('roles');
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
