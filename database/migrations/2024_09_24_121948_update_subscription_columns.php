<?php
use App\Models\Subscription;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $subscriptions = Subscription::all();
        foreach ($subscriptions as $subscription) {
            $subscription->max_chatwidget = $subscription->plan->max_chatwidget ?? 0;
            $subscription->max_flow_builder = $subscription->plan->max_flow_builder ?? 0;
            $subscription->max_bot_reply = $subscription->plan->max_bot_reply ?? 0;
            $subscription->save();
        }
    }

    public function down()
    {
    }
};
