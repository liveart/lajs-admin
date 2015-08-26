<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddImageFileFieldsToGraphicsItemsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('graphicsItems', function(Blueprint $table) {     
            
            $table->string('imageFile_file_name')->nullable();
            $table->integer('imageFile_file_size')->nullable();
            $table->string('imageFile_content_type')->nullable();
            $table->timestamp('imageFile_updated_at')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graphicsItems', function(Blueprint $table) {

            $table->dropColumn('imageFile_file_name');
            $table->dropColumn('imageFile_file_size');
            $table->dropColumn('imageFile_content_type');
            $table->dropColumn('imageFile_updated_at');

        });
    }

}
