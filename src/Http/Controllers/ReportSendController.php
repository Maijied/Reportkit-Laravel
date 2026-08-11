<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * ReportSendController — POST send prepared report as ZIP attachment (Phase B5).
 */

namespace ReportKit\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use ReportKit\Core\Http\AjaxResponse;
use ReportKit\Core\Http\HandlesReportSend;

/**
 * POST send prepared report as ZIP attachment (Phase B5).
 */
class ReportSendController
{
    use HandlesReportSend;

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, $slug)
    {
        $config = config('reportkit', []);
        $config['mail_enabled'] = config('reportkit.mail.enabled', true);
        $rows = $request->session()->get($this->preparedSessionKey($slug), []);

        $payload = $this->reportSendPayload($slug, $request->all(), $config, is_array($rows) ? $rows : []);

        if (AjaxResponse::isError($payload)) {
            $status = AjaxResponse::status($payload);
            unset($payload['_status']);

            return response()->json($payload, $status);
        }

        $plan = isset($payload['_mail_plan']) ? $payload['_mail_plan'] : null;
        unset($payload['_mail_plan']);

        if ($plan && class_exists('\Illuminate\Support\Facades\Mail')) {
            try {
                $this->dispatchMail($plan, $config);
                $payload['message'] = 'Report sent.';
            } catch (\Exception $e) {
                return response()->json(array(
                    'ok' => false,
                    'error' => 'Could not send mail on this host.',
                ), 500);
            }
        } else {
            $payload['message'] = 'Send plan ready — wire host mailer to dispatch.';
        }

        return response()->json($payload);
    }

    /**
     * @param array $plan
     * @param array $config
     * @return void
     */
    protected function dispatchMail(array $plan, array $config)
    {
        $view = isset($config['mail']['view']) ? $config['mail']['view'] : 'reportkit::emails.send';
        $to = $plan['email'];
        $attachment = $plan['attachment'];

        \Illuminate\Support\Facades\Mail::send($view, array(
            'intro' => 'Your prepared report is attached.',
        ), function ($message) use ($to, $attachment) {
            $message->to($to)->subject('Report export');
            $message->attachData($attachment['bytes'], $attachment['filename'], array(
                'mime' => $attachment['mime'],
            ));
        });
    }

    /**
     * @param string $serviceClass
     * @return object
     */
    protected function makeReportService($serviceClass)
    {
        try {
            return app($serviceClass);
        } catch (\Exception $e) {
            return new $serviceClass();
        } catch (\Throwable $e) {
            return new $serviceClass();
        }
    }
}
