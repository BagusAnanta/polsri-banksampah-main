<?php

namespace Tests\Unit;

use App\Models\Masyarakat;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class MasyarakatNikTest extends TestCase
{
    public function test_plain_text_nik_is_returned_as_is()
    {
        $masyarakat = new Masyarakat();
        $masyarakat->nik = '1234567890123456';

        $this->assertSame('1234567890123456', $masyarakat->decrypted_nik);
    }

    public function test_encrypted_nik_is_decrypted()
    {
        $masyarakat = new Masyarakat();
        $masyarakat->nik = Crypt::encryptString('1234567890123456');

        $this->assertSame('1234567890123456', $masyarakat->decrypted_nik);
    }
}
