@extends('emails.master')

@section('content')
    <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
        <h1 class="size-32" style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;font-size: 32px;line-height: 40px;color: #333;text-align: center;">Verify your E-Mail</h1>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div style="line-height:10px;font-size:1px">&nbsp;</div>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;">
        <div style="line-height:10px;font-size:1px">&nbsp;</div>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;">
        <p class="size-16" style="Margin-top: 16px;Margin-bottom: 20px;font-size: 16px;line-height: 24px;">
            You have registered for a membership at "{{ trans('messages.title') }}", to get access to the Tool please verify your E-Mail address.
        </p>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
        <div class="btn btn--flat" style="text-align:center;">
            <![if !mso]><a style="border-radius: 4px;display: inline-block;font-weight: bold;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #fb7700;font-family: 'Open Sans', sans-serif;font-size: 14px;line-height: 24px;padding: 12px 35px;" href="{{ aurl('auth/confirm/'.$user->confirmation_token) }}" data-width="112">verify E-Mail</a><![endif]>
            <!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p>
            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{{ aurl('auth/confirm/'.$user->confirmation_token) }}" style="width:182px" arcsize="9%" fillcolor="#FB7700" stroke="f">
                <v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px">
                    <center style="font-size:14px;line-height:24px;color:#FFFFFF;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">
                        verify E-Mail
                    </center>
                </v:textbox>
            </v:roundrect><![endif]-->
        </div>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;">
        <p class="size-16" style="Margin-top: 16px;Margin-bottom: 20px;font-size: 16px;line-height: 24px;">
            {{ aurl('auth/confirm/'.$user->confirmation_token) }}
        </p>
    </div>
@endsection