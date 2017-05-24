<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorsDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // These drop statements are required for a full refactor of the database
        // This migration is irreversible by nature because it deeply changes the
        // database schema
        Schema::dropIfExists('comments');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('printers');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
        Schema::dropIfExists('departaments');
        Schema::dropIfExists('departments');


        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('profile_url')->nullable();
            $table->string('presentation')->nullable();

            // Non-normalized fields to handle statistics
            // They are maintained by the application layer
            // Usage is not required
            $table->integer('print_evals')->default(0);
            $table->integer('print_counts')->default(0);
            $table->timestamps();

            // A single tinyint can hold many state flags
            // But in sake of simplicity each flag is expressed as a bool
            $table->boolean('admin')->default(false);
            $table->boolean('blocked')->default(false);
            $table->boolean('activated')->default(false);

            // Foreign keys
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            // This token can be used for password reset or account activations
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('status');
            //$table->dateTime('open_date'); // duplication of field created_at
            $table->dateTime('due_date')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->smallInteger('paper_size');
            $table->smallInteger('paper_type');
            $table->string('file');
            $table->dateTime('closed_date')->nullable();
            $table->string('refused_reason')->nullable();
            $table->smallInteger('satisfaction_grade')->nullable();
            $table->timestamps();

            // A single tinyint can hold many state flags
            // But in sake of simplicity each flag is expressed as a bool
            $table->boolean('colored')->default(false);
            $table->boolean('stapled')->default(false);
            $table->boolean('front_back')->default(false);

            // Foreign keys
            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users');

            $table->integer('printer_id')->unsigned()->nullable();
            $table->foreign('printer_id')->references('id')->on('printers');

            $table->integer('closed_user_id')->unsigned()->nullable();
            $table->foreign('closed_user_id')->references('id')->on('users');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->boolean('blocked')->default(false);
            $table->timestamps();

            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');

            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('comments');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // We are just creating the wrongly named table to be able to run
        // artisan migration:refresh --seed
        Schema::create('departaments', function (Blueprint $table) {
            $table->increments('id');
        });
    }
}
