# Afp, es una Login Scraper a las AFPs Chilenas


Afp es un libreria que se conecta con una Afp con las claves dadas y realiza scrapign para obtener los datos necesarios.

Esta libreria de preferencia debe ser usada solamente para monitoreo de las propias cuentas y ejecutada como segundo plano.

## Requirientos

Afp depende de PHP 7.1+.

Agrega ``cristian/afp`` como dependencia requerida en tu archivo ``composer.json``:


    composer require cristian/afp

## Uso


Crea una instancia de la Afp que quieres (actualmente solo esta disponible Habitad), con tus claves

    use Afp\Habitad;

    $habitad = new Afp\Habitad([
        'rut' => 'xxxx', // sin puntos ni guion 
        'password' => 'xxxx'
    ]);

### Metodos

SaldoTotal: retorna la suma total del balance de todas tus cuentas en la afp

    $habitad->SaldoTotal();

SaldoObligatorio: retorna el balance de tu cuenta obligatoria

    $habitad->SaldoObligatorio();

SaldoCuenta2: retorna el balance de tu cuenta volutarioa (cuenta 2)

    $habitad->SaldoCuenta2();

## Licencia

Afp esta bajo la licencia MIT