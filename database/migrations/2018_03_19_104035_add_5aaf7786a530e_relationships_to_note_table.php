<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5aaf7786a530eRelationshipsToNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function(Blueprint $table) {
            if (!Schema::hasColumn('notes', 'property_id')) {
                $table->integer('property_id')->unsigned()->nullable();
                $table->foreign('property_id', '132513_5aaf77846e0ff')->references('id')->on('properties')->onDelete('cascade');
                }
                if (!Schema::hasColumn('notes', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '132513_5aaf778479bda')->references('id')->on('users')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function(Blueprint $table) {
            
        });
    }
}
