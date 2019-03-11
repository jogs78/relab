<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->subject(Lang::getFromJson('Notificación de Restablecimiento de Contraseña'))
            //Para cambiar el saludo para el correo
            ->greeting('Hola ' . $notifiable->name)
            ->line(Lang::getFromJson('Si estas viendo este correo es porque recibimos una solicitud para restablecer la contraseña de tu cuenta.'))
            ->action(Lang::getFromJson('Restablecer Contraseña'), url(config('app.url').route('password.reset', $this->token, false)))
            ->line(Lang::getFromJson('Presiona sobre el botón para que cambies tu contraseña de lo contrario, va a expirar en :count minutos.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::getFromJson('Si no hiciste esta solicitud para cambiar tu contraseña, puedes ignorar este correo y nada habrá cambiado.'))
            //Mensaje final del correo
            ->salutation('¡Saludos!');
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
