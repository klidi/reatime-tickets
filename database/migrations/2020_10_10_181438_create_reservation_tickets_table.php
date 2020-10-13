<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reservation_id')
                ->unsigned()
                ->index()
                ->foreign()
                ->references("id")
                ->on('reservations')
                ->onDelete("cascade");
            $table->bigInteger('ticket_id')
                ->unsigned()
                ->index()
                ->foreign()
                ->references("id")
                ->on('tickets')
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_tickets');
    }
}
