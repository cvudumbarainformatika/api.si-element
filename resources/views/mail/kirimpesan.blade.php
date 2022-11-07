<x-mail::message>
    # SIMTEM INFORMASI LIPA MITRA
    {{ $data_email['title'] }}

    Nama Lengkap : {{ $data_email['nama'] }}
    Email : {{ $data_email['email'] }}
    Password : {{ $data_email['password'] }}

    <x-mail::button :url="$data_email['url']" color="success">
        Login
    </x-mail::button>
    <x-mail::panel>
        Data ini bersifat rahasia mohon untuk tidak disebar kepada siapapun
    </x-mail::panel>

    Terimakasih
    SIMTEM INFORMASI LIPA MITRA
</x-mail::message>
