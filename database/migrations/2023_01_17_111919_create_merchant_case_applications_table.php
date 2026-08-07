<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantCaseApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_case_applications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->bigInteger('case_id')->nullable();
            $table->string('website_link')->nullable();
            $table->string('commenced_date')->nullable();
            $table->string('date_incorporated')->nullable();
            $table->string('type_of_business')->nullable();
            $table->string('lagal_name')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('legal_street_address')->nullable();
            $table->string('legal_business_city')->nullable();
            $table->string('legal_landmark')->nullable();
            $table->string('legal_business_state')->nullable();
            $table->string('legal_business_postal_code')->nullable();
            $table->string('legal_business_phone')->nullable();
            $table->string('legal_business_fax')->nullable();
            $table->string('legal_registration')->nullable();
            $table->string('trading_business_name')->nullable();
            $table->string('trading_address')->nullable();
            $table->string('street_address')->nullable();
            $table->string('business_city')->nullable();
            $table->string('business_state')->nullable();
            $table->string('business_postal_code')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_fax')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('owner_first_name')->nullable();
            $table->string('owner_last_name')->nullable();
            $table->string('owner_position')->nullable();
            $table->string('owner_date_of_birth')->nullable();
            $table->string('owner_address')->nullable();
            $table->string('owner_location')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_identity_number')->nullable();
            $table->string('owner_identification_type')->nullable();
            $table->string('owner_is_owner')->nullable();
            $table->string('bank_account_holder_name')->nullable();
            $table->string('bank_routing_number')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('payment_advise_remittance')->nullable();
            $table->string('payment_expected_monthly_volume')->nullable();
            $table->string('visa_card_volume')->nullable();
            $table->string('master_card_volume')->nullable();
            $table->string('other_card_volume')->nullable();
            $table->string('business_summary')->nullable();
            $table->string('transaction_type_internet')->nullable();
            $table->string('transaction_type_moto')->nullable();
            $table->string('transaction_type_credit_card_present')->nullable();
            $table->string('credit_card_sales_to_business')->nullable();
            $table->string('credit_card_sales_to_consumer')->nullable();
            $table->string('good_sales_0_days')->nullable();
            $table->string('good_sales_1_7_days')->nullable();
            $table->string('good_sales_8_14_days')->nullable();
            $table->string('good_sales_15_30_days')->nullable();
            $table->string('good_sales_over_30_days')->nullable();
            $table->string('description_for_goods')->nullable();
            $table->string('agreement_detail')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('merchant_case_applications');
    }
}
