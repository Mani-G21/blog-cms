<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Blog Added</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; margin: 20px auto; border-collapse: collapse; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <tr>
            <td align="center" style="background-color: #f5481d; color: #ffffff; padding: 20px 0;">
                <h1 style="margin: 0; font-size: 24px;"> New Blog Alert! </h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: left;">
                <h2 style="margin: 0 0 10px; font-size: 20px; color: #333;">{{$post->title}}</h2>
                <p style="margin: 0 0 15px; color: #555; font-size: 16px; line-height: 1.5;">{{$post->excerpt}}</p>
                <p style="text-align: center;">
                    <a href="{{$post->url}}" style="background-color: #f5481d; color: #ffffff; text-decoration: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; display: inline-block;">
                        Read Blog
                    </a>
                </p>
            </td>
        </tr>
        <tr>
            <td align="center" style="background-color: #f4f4f4; color: #777; font-size: 14px; padding: 10px;">
                <p style="margin: 0;">You received this email because you subscribed to blog updates.</p>

            </td>
        </tr>
    </table>
</body>
</html>
