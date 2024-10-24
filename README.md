[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/bHiSd6jz)
# Tworzenie Prostej Bazy Danych MySQL i Wyświetlanie Danych za Pomocą PHP (Podejście Proceduralne)

W tym tutorialu nauczysz się:

- Jak utworzyć prostą bazę danych w MySQL.
- Jak dodać kilka rekordów do bazy.
- Jak odczytać i wyświetlić dane na stronie internetowej za pomocą PHP (podejście proceduralne).
- Jak dodać prosty formularz do filtrowania danych po nazwisku.

**Środowisko pracy:**

- **XAMPP** – do uruchomienia serwera lokalnego.
- **Visual Studio Code** – do edycji kodu.
- **GitHub Classroom** – do zarządzania kodem.

---

## 1. Przygotowanie Środowiska

### a) Uruchomienie XAMPP

1. **Uruchom XAMPP**.
2. W panelu sterowania XAMPP kliknij **Start** przy **Apache** i **MySQL**.

### b) Otworzenie phpMyAdmin

1. W przeglądarce internetowej wpisz adres: `http://localhost/phpmyadmin/`.

---

## 2. Tworzenie Bazy Danych i Tabeli

### a) Utworzenie Nowej Bazy Danych

1. W phpMyAdmin kliknij na zakładkę **"Bazy danych"**.
2. W polu **"Utwórz bazę danych"** wpisz nazwę bazy, np. **"szkola"**.
3. Kliknij **"Utwórz"**.

### b) Utworzenie Tabeli "uczniowie"

1. Wybierz bazę danych **"szkola"** z listy po lewej stronie.
2. Kliknij **"Utwórz tabelę"** i nazwij ją **"uczniowie"**.
3. Ustaw liczbę kolumn na **4** i kliknij **"Wykonaj"**.

### c) Definiowanie Kolumn Tabeli

| Nazwa kolumny | Typ        | Długość/Wartości | Atrybuty | Indeks | A_I (Auto Increment) |
|---------------|------------|------------------|----------|--------|----------------------|
| id            | INT        | 11               |          | PRIMARY| TAK                  |
| imie          | VARCHAR    | 50               |          |        |                      |
| nazwisko      | VARCHAR    | 50               |          |        |                      |
| wiek          | INT        | 11               |          |        |                      |

1. Po wprowadzeniu danych kliknij **"Zapisz"**.

---

## 3. Dodawanie Rekordów do Tabeli

### a) Wprowadzanie Danych

1. Wybierz tabelę **"uczniowie"**.
2. Kliknij zakładkę **"Wstaw"**.
3. Wprowadź dane dla kilku uczniów. Przykład:

   - **imie**: Jan
   - **nazwisko**: Kowalski
   - **wiek**: 17

4. Kliknij **"Wykonaj"**.
5. Powtórz kroki, aby dodać więcej uczniów.

---

## 4. Tworzenie Strony PHP do Wyświetlania Danych (Podejście Proceduralne)

### a) Utworzenie Nowego Pliku PHP

1. Otwórz **Visual Studio Code**.
2. W folderze **htdocs** (np. `C:\xampp\htdocs\`) utwórz nowy folder, np. **"projekt"**.
3. W folderze **"projekt"** utwórz nowy plik o nazwie **"index.php"**.

### b) Połączenie z Bazą Danych

W pliku **"index.php"** wprowadź poniższy kod:

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "szkola";

// Tworzenie połączenia
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}
?>
```

### c) Pobieranie i Wyświetlanie Danych

Dodaj poniższy kod po wcześniejszym:

```php
<?php
$sql = "SELECT * FROM uczniowie";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tr><th>Imię</th><th>Nazwisko</th><th>Wiek</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td>".$row["wiek"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Brak wyników";
}
mysqli_close($conn);
?>
```

### d) Sprawdzenie Wyniku

1. W przeglądarce internetowej wpisz adres: `http://localhost/projekt/index.php`.
2. Powinna wyświetlić się tabela z danymi uczniów.

---

## 5. Dodanie Formularza do Filtrowania Danych

### a) Utworzenie Formularza

Dodaj poniższy kod HTML przed kodem PHP w pliku **"index.php"**:

```php
<form method="POST" action="index.php">
    Wpisz nazwisko: <input type="text" name="nazwisko">
    <input type="submit" value="Filtruj">
</form>
```

### b) Modyfikacja Kodu PHP do Filtrowania

Zamień poprzedni kod PHP na poniższy:

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "szkola";

// Tworzenie połączenia
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

if(isset($_POST['nazwisko']) && $_POST['nazwisko'] != '') {
    $nazwisko = $_POST['nazwisko'];

    // Zabezpieczenie przed SQL Injection
    $nazwisko = mysqli_real_escape_string($conn, $nazwisko);

    $sql = "SELECT * FROM uczniowie WHERE nazwisko='$nazwisko'";
} else {
    $sql = "SELECT * FROM uczniowie";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tr><th>Imię</th><th>Nazwisko</th><th>Wiek</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td>".$row["wiek"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Brak wyników";
}
mysqli_close($conn);
?>
```

**Ważne:** Użyliśmy funkcji `mysqli_real_escape_string()`, aby zabezpieczyć się przed atakami typu SQL Injection.

### c) Sprawdzenie Filtrowania

1. Odśwież stronę w przeglądarce: `http://localhost/projekt/index.php`.
2. W polu **"Wpisz nazwisko"** wpisz nazwisko ucznia, np. **"Kowalski"**.
3. Kliknij **"Filtruj"**.
4. Powinna wyświetlić się tabela tylko z uczniami o podanym nazwisku.

---

## 6. Zakończenie

Gratulacje! Udało Ci się:

- Utworzyć bazę danych i tabelę w MySQL.
- Dodać rekordy do tabeli.
- Napisać skrypt PHP do wyświetlania danych (podejście proceduralne).
- Dodać formularz do filtrowania danych.

**Pamiętaj:** Zawsze możesz wrócić do tego tutorialu, jeśli czegoś zapomnisz lub potrzebujesz pomocy.

---

## Wskazówki dla Uczniów

- **Czytaj uważnie** każdy krok i wykonuj go po kolei.
- **Kopiuj i wklejaj** kod, aby uniknąć literówek.
- Jeśli pojawi się błąd, **sprawdź** dokładnie swój kod i porównaj z tutorialem.
- **Pytaj nauczyciela** lub kolegów, jeśli czegoś nie rozumiesz.

---

**Powodzenia w dalszej nauce programowania!**
