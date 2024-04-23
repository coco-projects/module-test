<?php

    use Coco\cocoApp\Kernel\CocoApp;
    use Coco\cron\abstract\JobAbstract;
    use Coco\cron\Schedule;
    use Coco\cron\job\CallableJob;

    return function(Schedule $schedule) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = CocoApp::getInstance();
        $appName = \Coco\cocoApp\KernelModule\Info::getAppName();

        /*-----------------------------------------------------------*/

        $schedule->before(function(Schedule $schedule) {
            echo '$schedule-before-1' . PHP_EOL;
        });

        $schedule->before(function(Schedule $schedule) {
            echo '$schedule-before-2' . PHP_EOL;
        });

        $schedule->after(function(Schedule $schedule) {
            echo '$schedule-after-1' . PHP_EOL;
        });

        $schedule->after(function(Schedule $schedule) {
            echo '$schedule-after-2' . PHP_EOL;
        });

        /*-----------------------------------------------------------*/

        $job1 = new CallableJob(function() {
            echo 'run-------------' . PHP_EOL;
        });

        $job1->before(function(JobAbstract $job) {
            echo '$job1-before-1' . PHP_EOL;
        });

        $job1->before(function(JobAbstract $job) {
            echo '$job1-before-2' . PHP_EOL;
        });

        $job1->after(function(JobAbstract $job) {
            echo '$job1-after-1' . PHP_EOL;
        });

        $job1->after(function(JobAbstract $job) {
            echo '$job1-after-2' . PHP_EOL;
        });

        $job1->setDescription('test111');
        $job1->cron(' * * * * */5');
        $schedule->addJob($job1);

        /*-----------------------------------------------------------*/

        $job2 = new CallableJob(function() {
            echo '$job2-run-------------' . PHP_EOL;
            throw new \Exception('$job2-Exception');
        });

        $job2->before(function(JobAbstract $job) {
            echo '$job2-before-1' . PHP_EOL;
        });

        $job2->before(function(JobAbstract $job) {
            echo '$job2-before-2' . PHP_EOL;
        });

        $job2->after(function(JobAbstract $job) {
            echo '$job2-after-1' . PHP_EOL;
        });

        $job2->after(function(JobAbstract $job) {
            echo '$job2-after-2' . PHP_EOL;
        });

        $job2->onError(function(JobAbstract $job) {
            echo '$job2-error-1' . PHP_EOL;
        });

        $job2->onError(function(JobAbstract $job) {
            echo '$job2-error-2' . PHP_EOL;
        });

        $job2->setDescription('test222');
        $job2->cron(' * * * * *');

        $schedule->addJob($job2);
        /*-----------------------------------------------------------*/

    };