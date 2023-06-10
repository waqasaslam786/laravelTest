<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        // Movies table
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        // Show Time
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained();
            $table->dateTime('start_time');
            $table->timestamps();
        });

        //showrooms 
        Schema::create('showrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // showroom_showtimes

        Schema::create('showroom_showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('showroom_id')->constrained();
            $table->foreignId('showtime_id')->constrained();
            $table->timestamps();
        });

        // Pricing
        Schema::create('show_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('showtime_id')->constrained();
            $table->string('seat_type');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        // seats
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // seat_bookings

        Schema::create('seat_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('showtime_id')->constrained();
            $table->foreignId('seat_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        // movies
        Schema::dropIfExists('movies');

        // showtime
        Schema::dropIfExists('showtimes');

        // Showrome
        Schema::dropIfExists('showrooms');

        // showroom_showtimes
        Schema::dropIfExists('showroom_showtimes');

        // show_pricings

        Schema::dropIfExists('show_pricings');

        // seats
        Schema::dropIfExists('seats');

        // seat_bookings
        Schema::dropIfExists('seat_bookings');
    }
}