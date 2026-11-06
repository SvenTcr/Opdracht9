<?php
//Naam: Sven Boender
//Opdr: Wakken en IJsberen
session_start();

function berekenWakkenEnIJsberen($dobbelstenen) {
    $wakken = 0;
    $ijsberen = 0;

    foreach ($dobbelstenen as $steen) {
        switch ($steen) {
            case 1:
                $wakken += 1;
                $ijsberen += 0;
                break;

            case 3:
                $wakken += 1;
                $ijsberen += 2;
                break;

            case 5:
                $wakken += 1;
                $ijsberen += 4;
                break;

            // Bij 2, 4 en 6 geen wakken of ijsberen.
            case 2:
            case 4:
            case 6:
                break;
        }
    }

    return [
        "wakken" => $wakken,
        "ijsberen" => $ijsberen
    ];
}

// Dobbelstenen
if (isset($_POST['gooien'])) {
    $aantal = (int) $_POST['aantal'];

    // minimaal 3 maximaal 8 dobbelstenen
    if ($aantal >= 3 && $aantal <= 8) {
        $_SESSION['dobbelstenen'] = [];

        for ($i = 0; $i < $aantal; $i++) {
            $_SESSION['dobbelstenen'][] = random_int(1, 6);
        }

        unset($_SESSION['gecontroleerd']);
        unset($_SESSION['melding']);
    }
}

// Antwoord
if (isset($_POST['controleren']) &&
    isset($_SESSION['dobbelstenen'])) {

    $resultaat = berekenWakkenEnIJsberen(
        $_SESSION['dobbelstenen']
    );

    $geradenWakken = (int) $_POST['wakken'];
    $geradenIJsberen = (int) $_POST['ijsberen'];

    if ($geradenWakken == $resultaat['wakken'] &&
        $geradenIJsberen == $resultaat['ijsberen']) {

        $_SESSION['melding'] = "Goed gedaan! Beide antwoorden zijn correct.";
        $_SESSION['goed'] = true;

    } else {
        $_SESSION['melding'] = "Helaas, het antwoord is niet helemaal goed.";
        $_SESSION['goed'] = false;
    }

    $_SESSION['gecontroleerd'] = true;
}

$dobbelsteenSymbolen = [
    1 => "1",
    2 => "2",
    3 => "3",
    4 => "4",
    5 => "5",
    6 => "6"
];

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wakken en IJsberen</title>

    <style>
        :root {
            --ink: #263238;
            --muted: #607078;
            --paper: #fff;
            --page: #f1f4f5;
            --green: #39745b;
            --green-dark: #2e5e49;
            --line: #dce3e5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 36px 20px;
            color: var(--ink);
            background: var(--page);
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            padding: 32px;
            background: var(--paper);
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(38, 50, 56, 0.08);
        }

        h1 {
            margin: 0 0 12px;
            color: var(--green);
        }

        .container > p {
            max-width: 440px;
            margin: 0 auto 28px;
            color: var(--muted);
            line-height: 1.65;
        }

        h2,
        h3 {
            color: var(--green-dark);
        }

        hr {
            height: 1px;
            margin: 26px 0;
            background: var(--line);
            border: 0;
        }

        .dobbelstenen {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 22px 0;
        }

        .dobbelsteen {
            display: grid;
            width: 64px;
            height: 64px;
            place-items: center;
            color: var(--green-dark);
            background: #f5f7f7;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 36px;
            font-weight: 700;
            line-height: 1;
        }

        button {
            color: #fff;
            background: var(--green);
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            margin: 12px 8px;
            transition: background 160ms ease;
        }

        button:hover,
        button:focus-visible {
            background: var(--green-dark);
        }

        button:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 3px solid rgba(225, 131, 77, 0.55);
            outline-offset: 3px;
        }

        input, select {
            min-height: 42px;
            padding: 10px 14px;
            margin: 10px 6px;
            color: var(--ink);
            background: #fff;
            border: 1px solid #d9d0c2;
            border-radius: 7px;
            font: inherit;
            font-size: 1rem;
            text-align: center;
        }

        select {
            cursor: pointer;
        }

        input {
            width: 120px;
        }

        .melding {
            padding: 14px 18px;
            margin-top: 24px;
            color: #28513c;
            background: #e6f0e5;
            border: 1px solid #cee0cc;
            border-radius: 8px;
        }

        .fout {
            color: #853f30;
            background: #fae9df;
            border-color: #efcdbb;
        }

        .uitleg {
            padding: 18px;
            margin-top: 32px;
            background: #f6f8f8;
            border: 1px solid var(--line);
            border-radius: 10px;
        }

        .uitleg h3 {
            margin-top: 0;
        }

        .uitleg p {
            margin: 10px 0;
            color: #48564d;
        }

        @media (max-width: 520px) {
            body {
                padding: 20px 12px;
            }

            .container {
                padding: 26px 18px;
            }

            .dobbelsteen {
                width: 56px;
                height: 56px;
                font-size: 30px;
            }
        }
    </style>

</head>

<body>

<div class="container">

    <h1>Wakken en IJsberen</h1>

    <p>
        Gooi de dobbelstenen en probeer te ontdekken
        hoeveel wakken en ijsberen er zijn!
    </p>

    <form method="POST">

        <label for="aantal">Aantal dobbelstenen:</label>

        <select name="aantal" id="aantal">

            <?php for ($i = 3; $i <= 8; $i++): ?>

                <option value="<?php echo $i; ?>">
                    <?php echo $i; ?>
                </option>

            <?php endfor; ?>

        </select>

        <br>

        <button type="submit" name="gooien">
            Gooi dobbelstenen
        </button>

    </form>

    <?php if (isset($_SESSION['dobbelstenen'])): ?>

        <hr>

        <h2>De worp</h2>

        <div class="dobbelstenen">

            <?php foreach ($_SESSION['dobbelstenen'] as $steen): ?>

                <span class="dobbelsteen">
                    <?php echo $dobbelsteenSymbolen[$steen]; ?>
                </span>

            <?php endforeach; ?>

        </div>

        <h3>Hoeveel wakken en ijsberen zie je?</h3>

        <form method="POST">

            <label for="wakken">Aantal wakken:</label>
            <br>

            <input
                type="number"
                name="wakken"
                id="wakken"
                min="0"
                required
            >

            <br>

            <label for="ijsberen">Aantal ijsberen:</label>
            <br>

            <input
                type="number"
                name="ijsberen"
                id="ijsberen"
                min="0"
                required
            >

            <br>

            <button type="submit" name="controleren">
                Controleer antwoord
            </button>

        </form>

    <?php endif; ?>

    <?php if (isset($_SESSION['melding'])): ?>

        <div class="melding
            <?php echo $_SESSION['goed'] ? '' : 'fout'; ?>">

            <h3>
                <?php echo htmlspecialchars($_SESSION['melding']); ?>
            </h3>

            <?php if ($_SESSION['goed']): ?>

                <p>Je hebt het goed geraden!</p>

            <?php else: ?>

                <?php
                $antwoord = berekenWakkenEnIJsberen(
                    $_SESSION['dobbelstenen']
                );
                ?>

                <p>
                    Het juiste aantal wakken is:
                    <strong><?php echo $antwoord['wakken']; ?></strong>
                </p>

                <p>
                    Het juiste aantal ijsberen is:
                    <strong><?php echo $antwoord['ijsberen']; ?></strong>
                </p>

            <?php endif; ?>

        </div>

    <?php endif; ?>

    <div class="uitleg">

        <h3>Spelregels</h3>

        <p>Dobbelsteen 1 = 1 wak, 0 ijsberen</p>
        <p>Dobbelsteen 3 = 1 wak, 2 ijsberen</p>
        <p>Dobbelsteen 5 = 1 wak, 4 ijsberen</p>
        <p>Dobbelstenen 2, 4 en 6 = 0 wakken, 0 ijsberen</p>

    </div>

</div>

</body>
</html>