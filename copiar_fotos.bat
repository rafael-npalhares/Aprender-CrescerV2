@echo off
:: Execute na RAIZ do projeto Laravel
:: Ajuste ORIGEM para a pasta onde estao suas fotos

set ORIGEM=%USERPROFILE%\Downloads

:: Cria a pasta destino dentro do projeto
if not exist "public\img\cantina" mkdir "public\img\cantina"

echo Copiando fotos para public\img\cantina\ ...
echo.

copy "%ORIGEM%\espetinho-da-lou-819x1024.jpeg"                                           "public\img\cantina\espetinho.jpeg"
copy "%ORIGEM%\images__1_.jfif"                                                           "public\img\cantina\mini-pizza.jpg"
copy "%ORIGEM%\66aa8788e70723_88296063.png"                                               "public\img\cantina\wrap-frango.png"
copy "%ORIGEM%\hot-dog-classico-012-730x548.jpeg"                                         "public\img\cantina\hot-dog.jpeg"
copy "%ORIGEM%\360_F_430706799_y9oKooR7hz7vYb8qm7e9gRUZkID0PfYD.jpg"                    "public\img\cantina\esfirra.jpg"
copy "%ORIGEM%\EJYAQDUVLJCZ5L52OS6JAFTKBE.jpeg"                                          "public\img\cantina\pastel.jpeg"
copy "%ORIGEM%\depositphotos_164071266-stock-photo-bottles-and-cans-of-assorted.jpg"     "public\img\cantina\refrigerante.jpg"

echo.
echo Rodando seeder...
php artisan db:seed --class=ProdutoCantinaSeeder

echo.
echo Pronto! Pressione qualquer tecla para fechar.
pause