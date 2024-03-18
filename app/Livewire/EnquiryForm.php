<?php

namespace App\Livewire;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use App\Models\Enquiry;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\Honeypot\Exceptions\SpamException;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;
use Spatie\Honeypot\SpamProtection;

class EnquiryForm extends Component implements HasForms
{
    use InteractsWithForms;
    use UsesSpamProtection;

    public $x = 20;
    public $y = 5;
    public $answer = 15;
    public $submitted = false;
    public HoneypotData $extraFields;

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    TextInput::make('first_name')->required(),
                    TextInput::make('last_name')->required(),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    TextInput::make('telephone')
                        ->tel()
                        ->nullable(),
                    TextInput::make('subject')
                        ->required()
                        ->columnSpanFull(),
                    Textarea::make('message')
                        ->rows(5)
                        //->maxLength(app(CmsSettings::class)->enquiries_max_characters)
                        ->required()
                        ->columnSpanFull(),
                    Textinput::make('quiz')
                        ->label('What is '.$this->x.' - '.$this->y.' ?')
                        ->required()
                        ->rules([
                            function () {
                                return function ($attribute, $value, \Closure $fail) {
                                    if ($value != $this->x - $this->y) {
                                        $fail("That answer is incorrect.");
                                    }
                                };
                            }
                        ])
                ])
                    ->columns(2)
            ])
            ->statePath('data');
    }

    public function resetQuiz()
    {
        $this->x = rand(10,20);
        $this->y = rand(1,5);
    }

    public function submit(): void
    {
        $this->submitted = true;
        $data = $this->form->getState();
        $data['ip_address'] = request()->ip();
        $honeypotData = $this->guessHoneypotDataProperty();
        try {
            app(SpamProtection::class)->check($honeypotData->toArray());
        } catch (SpamException) {
            $data['spam'] = true;
        }

        $enquiry = Enquiry::create($data);

    }

    public function mount()
    {
        $this->resetQuiz();
        $this->extraFields = new HoneypotData();
        $this->form->fill([]);
    }

    public function render(): View
    {
        return view('livewire.enquiry-form');
    }


//    public $x = 20;
//    public $y = 5;
//    public $answer = 15;
//    public $submitted = false;
//    public HoneypotData $extraFields;
//
//    public function resetQuiz()
//    {
//        $this->x = rand(10,20);
//        $this->y = rand(1,5);
//    }
//
//    public function mount()
//    {
//        $this->resetQuiz();
//        $this->extraFields = new HoneypotData();
//        $this->form->fill([]);
//    }
//
//    protected function getFormSchema(): array
//    {
//        return [
//
//        ];
//    }
//
//    protected function getFormModel(): string
//    {
//        return Enquiry::class;
//    }
//
//    public function submit(): void
//    {
//        $this->validate();
//        $this->submitted = true;
//        $data = $this->form->getState();
//        $data['ip_address'] = request()->ip();
//        $honeypotData = $this->guessHoneypotDataProperty();
//        try {
//            app(SpamProtection::class)->check($honeypotData->toArray());
//        } catch (SpamException) {
//            $data['spam'] = true;
//        }
//
//        //$enquiry = Enquiry::create($data);
//
//        // Create an AnonymousNotifiable instance
//        //$notifiable = (new AnonymousNotifiable());
//
//        //foreach( cms_settings('enquiry_recipients') ?? [] as $recipient)
//        //{
//        //    $notifiable->route('mail', $recipient['email'])->notify(new EnquiryFormSubmission($data,$recipient));
//        //}
//    }
//
//    public function render()
//    {
//        return view('livewire.enquiry-form');
//    }
}
