<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique Seu Email - Manager Box</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 320px; background-color: #f5f5f5;">
        <tr>
            <td align="center" style="padding: 40px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 8px;">

                    <tr>
                        <td align="center" style="padding: 40px 20px 20px 20px;">
                            {{-- É recomendado usar assets absolutos em e-mails --}}
                            <img src="{{ asset('img/logo-managerbox.png') }}" alt="Manager Box Logo" width="48" height="48" style="display: block; border: 0; margin-bottom: 10px;">
                            <h1 style="margin: 0; font-size: 24px; color: #333333;">Manager Box</h1>
                            <p style="margin: 5px 0 0 0; font-size: 14px; color: #666666;">Plataforma inteligente de gestão de estoques</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 40px; background-color: #fffaf0; border-radius: 8px;">

                            <p style="font-size: 16px; color: #333333; margin: 0 0 20px 0;">
                                <strong>Olá, {{ $userName }}!</strong>
                            </p>

                            <p style="font-size: 14px; color: #333333; margin: 0 0 30px 0;">
                                Por favor, clique no botão abaixo para verificar o seu email.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 0 0 30px 0;">
                                        {{-- Link de Verificação --}}
                                        <a href="{{ $verificationUrl }}" target="_blank" style="display: inline-block; padding: 12px 24px; background-color: #1a5631; color: #ffffff; text-decoration: none; border-radius: 4px; font-size: 16px; font-weight: bold;">
                                            Verificar email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; color: #333333; margin: 0 0 30px 0;">
                                Se não foi você quem criou uma conta, por favor, ignore esta mensagem.
                            </p>

                            <p style="font-size: 14px; color: #333333; margin: 0;">
                                Atenciosamente,<br><strong>Manager Box.</strong>
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 40px 10px 40px;">
                            <hr style="border: 0; border-top: 1px dashed #cccccc; margin: 0;">
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 10px 40px 40px 40px;">
                            <p style="font-size: 12px; color: #666666; text-align: center; margin: 0;">
                                Se está tendo problemas ao clicar no botão 'Verificar email', copie e cole este link na barra de busca de seu navegador:
                                <strong>
                                    <a href="{{ $verificationUrl }}" style="color: #1a5631; word-break: break-all;">
                                        {{ $verificationUrl }}
                                    </a>
                                </strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <p style="margin: 0; font-size: 12px; color: #999999;">
                                © 2025 Manager Box. Todos os direitos reservados.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>
