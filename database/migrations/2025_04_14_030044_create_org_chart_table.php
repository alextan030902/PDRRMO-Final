<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgChartTable extends Migration
{
    public function up()
    {
        Schema::create('org_charts', function (Blueprint $table) {
            $table->id();
            $table->string('org_chart_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('org_charts');
    }
}
