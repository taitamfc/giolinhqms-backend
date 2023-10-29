<?php
 
namespace App\View\Composers;
 
use Illuminate\View\View;
use App\Repositories\Eloquents\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
class ProfileComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected UserServiceInterface $user,
    ) {
        $this->user = $user;
    }
 
    /**
     * Bind data to the view.
     */
    // public function compose(View $view): void
    // {
    //     Facades\View::composer('*', function (View $view) {
    //         $dataEmail = 'Phireus2002@gmail.com';
    //         $user = $this->user->getInfoUser($dataEmail);
    //         $view->with('profile', $user->profile);
    //     });
    // }

    public function compose(View $view): void
    {
        $view->with('profile',$this->user->getInfoUser());
    }
}