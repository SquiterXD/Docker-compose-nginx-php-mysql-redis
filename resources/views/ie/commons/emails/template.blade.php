<html>
    <head></head>
    <body style="-webkit-font-smoothing: antialiased;
        -webkit-text-size-adjust: none;
        width: 100% !important;
        height: 100%;
        line-height: 1.6;">
        <table style="background-color: #f6f6f6;width: 100%;">
            <tr>
                <td></td>
                <td style="display: block !important;
                    max-width: 600px !important;
                    margin: 0 auto !important;
                    /* makes it centered */
                    clear: both !important;" width="600">
                    <div style="max-width: 600px;
                        margin: 0 auto;
                        display: block;
                        padding: 20px;">

                        {{-- EMAIL BODY --}}
                        <table style="background: #fff;
                            border: 1px solid #e9e9e9;
                            border-radius: 3px;" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                            {{-- EMAIL BODY TITLE --}}
                                <td style="font-size: 16px;
                                    color: #fff;
                                    font-weight: 500;
                                    padding: 20px;
                                    text-align: center;
                                    border-radius: 3px 3px 0 0;
                                    background: #1ab394;">

                                    {{ $title }}

                                </td>
                            </tr>
                            <tr>
                                {{-- EMAIL BODY DESCRIPTION --}}
                                <td style="padding: 20px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 0 0 10px;">
                                                {{-- You have <strong>1 free report</strong> remaining. --}}
                                                Dear {{ $receiverNames }},
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0 0 5px;">
                                                {{ $description }}
                                            </td>
                                        </tr>
                                        @if($reason)
                                        <tr>
                                            <td style="padding: 10px 20px;border: 1px solid #e7eaec;background-color: #f5f5f5;">
                                                {!! nl2br(e($reason)) !!}
                                            </td>
                                        </tr>
                                        @endif
                                        <tr><td style="padding: 0 0 20px;"></td></tr>
                                        <tr>
                                            {{-- BUTTON LINK --}}
                                            <td style="padding: 0 0 5px;">
                                                <a href="{{ url('/') }}/cash-advances/{{ $requestId }}" style="text-decoration: none;
                                                    color: #FFF;
                                                    font-size: 0.9em;
                                                    background-color: #1ab394;
                                                    border: solid #1ab394;
                                                    border-width: 4px 8px;
                                                    line-height: 2;
                                                    font-weight: bold;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    display: inline-block;
                                                    border-radius: 5px;
                                                    text-transform: capitalize;">
                                                    View Request
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- TEXT LINK --}}
                                            <td style="padding: 0 0 20px;">
                                                <a href="{{ url('/') }}/cash-advances/{{ $requestId }}">
                                                    <small>{{ url('/') }}/cash-advances/{{ $requestId }}</small>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0 0 20px;">
                                                Thank you.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        {{-- FOOTER --}}
                        {{-- <div style="width: 100%;
                            clear: both;
                            color: #999;
                            padding: 20px;">
                            <table width="100%">
                                <tr>
                                    <td style="text-align: center;padding: 0 0 20px;"><a href="#">Unsubscribe</a> from these alerts.</td>
                                </tr>
                            </table>
                        </div> --}}

                    </div>
                </td>
                <td></td>
            </tr>
        </table>
    </body>
</html>