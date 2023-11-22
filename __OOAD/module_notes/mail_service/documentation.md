# Mail Service Credentials :
1. 'smtp' => [
            'transport' => 'smtp',
            'host' =>  'smtp.sendgrid.net',
            'port' =>  587,
            'encryption' => 'tls',
            'username' => 'apikey',
            'password' => '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',
            'timeout' => null,
            'auth_mode' => null,
]

2.     'from' => [

        'address' =>  'Sayid.A@dsshield.com',
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    ### You can Find Those Credentials in 'config/mail.php' file



# Mail Service application code :
```
class Sendgrid implements MailInterface
{
    public function sendMail($userId, $subject, $body)
    {
        //getting the mail of user
        $email = new SendgridMail($subject, $body);
        $userEmail = User::where('id', $userId)->value('email');
        if ($userEmail) {
            try {
                //code...
                Mail::to($userEmail)->send($email);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
``` 
this code exists in 'app/Services/Mail/Sendgrid.php' .

# Mail Service usage code :

You can use mail service like this:

```
      (new MailServiceProvider)->send(new Sendgrid, $userId, $subject, $body);
```