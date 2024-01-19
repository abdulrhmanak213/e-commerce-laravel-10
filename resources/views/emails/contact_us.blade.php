<!DOCTYPE html>
<html>
<head>
    <title>Contact Us Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f0f0; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #333; text-align: center;">New Contact Us Submission</h1>
        
        <div style="padding: 10px;">
            <p><strong style="color: #333;">Full Name:</strong> {{ $data['full_name'] }}</p>
            <p><strong style="color: #333;">Email:</strong> {{ $data['phone_or_email'] }}</p>
        </div>

        <div style="padding: 10px; border-top: 1px solid #ddd;">
            <p style="color: #333;"><strong>Message:</strong></p>
            <p style="color: #555; padding: 10px; background-color: #f9f9f9; border-radius: 3px;">{{ $data['message'] }}</p>
        </div>
    </div>
</body>
</html>