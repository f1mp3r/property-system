<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('county')->nullable()->default(null);;
            $table->string('country')->nullable()->default(null);;
            $table->string('town')->nullable()->default(null);;
            $table->text('description')->nullable()->default(null);;
            $table->string('details_url')->nullable()->default(null);;
            $table->string('displayable_address')->nullable()->default(null);;
            $table->string('image_url')->nullable()->default(null);;
            $table->string('thumbnail_url')->nullable()->default(null);;
            $table->string('latitude')->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);
            $table->integer('bedrooms');
            $table->decimal('bathrooms', 3, 1);
            $table->decimal('price', 12);
            $table->string('type')->comment('sale or rent');
            $table->text('property_type')->default('{}');
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
        Schema::dropIfExists('properties');
    }
}
