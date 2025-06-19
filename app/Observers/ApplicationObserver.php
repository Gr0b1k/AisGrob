<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Container\Attributes\Auth;

class ApplicationObserver
{
    /**
     * Handle the Application "created" event.
     */
    public function created(Application $application): void
    {   
            $recipient = User::find(1);
            Notification::make()
            ->title('Создана новая заявка')
            ->success()
                ->actions([
                        Action::make('view')
                        ->button('Просмотр'),
                ])
            ->sendToDatabase($recipient);
    }

    /**
     * Handle the Application "updated" event.
     */

    public function updated(Application $application): void
    {
        //     $recipient = User::find(1);
        //     Notification::make()
        //     ->title('Заявка изменена')
        //     ->body('Добавлен ответ на заявку')
        //     ->success()
        //                     ->actions([
        //                 Action::make('view')
        //                 ->button('Просмотр'),
        //         ])
        //     ->sendToDatabase($recipient);
    }

    /**
     * Handle the Application "deleted" event.
     */
    public function deleted(Application $application): void
    {
    }

    /**
     * Handle the Application "restored" event.
     */
    public function restored(Application $application): void
    {
    }

    /**
     * Handle the Application "force deleted" event.
     */
    public function forceDeleted(Application $application): void
    {
    }
}
