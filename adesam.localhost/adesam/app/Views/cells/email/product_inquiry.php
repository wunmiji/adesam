<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email From Product Inquiry Form for <?= $unique; ?></title>
    <meta name="description" content="Contact Form">
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #fff;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" cellpadding="0" width="100%"
        style="@import url('https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&display=swap'); font-family: 'Barlow', sans-serif; border: 0; background-color: rgb(255, 102, 196);">
        <tr>
            <td>
                <table style="background-color: rgb(255, 102, 196); max-width:670px;  margin:0 auto; border: 0;" width="100%"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:30px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center; color: white; font-weight:600; font-size:18px; font-family:'Barlow',sans-serif;">Email From Product Inquiry Form for <?= $unique; ?></td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius: 0.25rem; text-align:left;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:20px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <div style="margin-bottom: 15px;">
                                            <h5 style="line-height:24px; font-weight:600; font-size:15px; font-family:'Barlow',sans-serif;">Name</h5>
                                            <p style="line-height:24px; font-weight:400; font-size:15px; font-family:'Barlow',sans-serif;"><?= $name; ?></p>
                                        </div>

                                        <div style="margin-bottom: 15px;">
                                            <h5 style="line-height:24px; font-weight:600; font-size:15px; font-family:'Barlow',sans-serif;">Email</h5>
                                            <p style="line-height:24px; font-weight:400; font-size:15px; font-family:'Barlow',sans-serif;"><?= $email; ?></p>
                                        </div>

                                        <div style="margin-bottom: 15px;">
                                            <h5 style="line-height:24px; font-weight:600; font-size:15px; font-family:'Barlow',sans-serif;">Message</h5>
                                            <p style="line-height:24px; font-weight:400; font-size:15px; font-family:'Barlow',sans-serif;"><?= $message; ?></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:40px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>