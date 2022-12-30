<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignedworks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('tasks')->nullable();
            $table->integer('status')->default(0); //0 = Pending, 1 = Ongoing, 2 = Completed
            $table->integer('department_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('kanban_id')->nullable();
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignedworks');
    }
};
