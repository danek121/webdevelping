<?php
// --- KONFIGURACJA ---
$adresOdbiorcy = "lizbud55@gmail.com"; // Adres, na który mają przychodzić wiadomości
$tematWiadomosci = "Nowa wiadomość ze strony LIZ-BUD";

// --- LOGIKA WYSYŁANIA ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Pobieranie i oczyszczanie danych z formularza (ochrona przed kodem złośliwym)
    $imie = htmlspecialchars(trim($_POST['imie']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $wiadomosc = htmlspecialchars(trim($_POST['wiadomosc']));

    // Sprawdzenie, czy pola nie są puste
    if (empty($imie) OR empty($wiadomosc) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Jeśli coś jest nie tak, wyświetl błąd i cofnij (JS)
        echo "<script>alert('Proszę wypełnić wszystkie pola poprawnie.'); window.history.back();</script>";
        exit;
    }

    // Treść wiadomości e-mail
    $trescEmaila = "Otrzymałeś nową wiadomość z formularza kontaktowego LIZ-BUD.\n\n";
    $trescEmaila .= "Imię i nazwisko: $imie\n";
    $trescEmaila .= "Email: $email\n\n";
    $trescEmaila .= "Wiadomość:\n$wiadomosc\n";

    // Nagłówki e-maila (kodowanie polskich znaków i ustawienie nadawcy)
    $naglowki = "MIME-Version: 1.0" . "\r\n";
    $naglowki .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
    
    // Ważne: Pole 'From' powinno być adresem serwera, a 'Reply-To' adresem klienta
    // Dzięki temu, gdy klikniesz "Odpowiedz", wyślesz maila do klienta.
    $naglowki .= "From: formularz@liz-bud.pl" . "\r\n"; 
    $naglowki .= "Reply-To: $email" . "\r\n";

    // Funkcja wysyłająca
    $sukces = mail($adresOdbiorcy, $tematWiadomosci, $trescEmaila, $naglowki);

    if ($sukces) {
        // Sukces - wyświetl komunikat i wróć na stronę główną
        echo "<script>
                alert('Dziękujemy! Wiadomość została wysłana.');
                window.location.href = 'index.html';
              </script>";
    } else {
        // Błąd serwera
        echo "<script>alert('Wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później.'); window.history.back();</script>";
    }

} else {
    // Jeśli ktoś spróbuje otworzyć plik bezpośrednio w przeglądarce
    header("Location: index.html");
    exit;
}
?>