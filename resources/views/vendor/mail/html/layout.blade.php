<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>{{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="color-scheme" content="light">
  <meta name="supported-color-schemes" content="light">

  <style>
    body {
      margin: 0;
      font-family: 'Helvetica Neue', Arial, sans-serif;
      background-color: #f4f6f9;
      color: #333;
    }

    .wrapper {
      width: 100%;
      background-color: #f4f6f9;
      padding: 20px 0;
    }

    .content {
      width: 100%;
    }

    .inner-body {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 40px;
    }

    .content-cell {
      font-size: 16px;
      line-height: 1.6;
      color: #444;
    }

    .header {
      padding: 20px 0;
      text-align: center;
    }

    .header img {
      max-height: 60px;
    }

    h1, h2, h3 {
      color: #2a2a2a;
      margin-bottom: 16px;
    }

    p {
      margin: 0 0 16px;
    }

    .footer {
      text-align: center;
      padding: 20px;
      font-size: 13px;
      color: #888;
    }

    @media only screen and (max-width: 600px) {
      .inner-body {
        width: 100% !important;
        padding: 20px !important;
      }

      .button {
        width: 100% !important;
        text-align: center !important;
      }
    }
  </style>

  {{ $head ?? '' }}
</head>

<body>
  <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center">
        <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">

          <!-- Header -->
          {{ $header ?? '' }}

          <!-- Body -->
          <tr>
            <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
              <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="content-cell">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                    {{ $subcopy ?? '' }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          {{ $footer ?? '' }}

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
