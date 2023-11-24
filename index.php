<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regresi Linear Sederhana</title>
    <link rel="icon" href="icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" async
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML">
        </script>
</head>

<body class="bg-[#DCF3F8] text-[#035466] font-body">
    <h1 class="text-2xl font-bold justify-center items-center mt-10 text-center">Selamat Datang Di Kalkulator<br>Regresi
        Linear Sederhana</h1>
    <div class="w-1/3 h-auto rounded-xl pb-10 mx-auto my-auto mt-6 bg-[#A0CED8]">
        <h1 class="font-medium pt-10 text-center">Silahkan Masukan Jumlah Baris</h1>
        <form class="justify-center items-center flex gap-4" action="" method="post">
            <input type="number" id="rowCount" name="rowCount" min="1" required
                class="w-1/3 p-2 mt-4 border rounded-md outline-[#035466]">
            <button type="submit" name="generate"
                class="mt-4 px-4 py-2 bg-[#327a8a] text-white rounded-md hover:bg-[#035466] focus:outline-none
                 focus:shadow-outline-blue active:bg-[#035466]">
                Generate
            </button>
        </form>

        <?php
        $rowCount = isset($_POST['rowCount']) ? intval($_POST['rowCount']) : 0;

        if ($rowCount > 0) {
            $nilai_x = isset($_POST['nilai_x']) ? $_POST['nilai_x'] : array_fill(0, $rowCount, 0);
            $nilai_y = isset($_POST['nilai_y']) ? $_POST['nilai_y'] : array_fill(0, $rowCount, 0);

            echo "<form action='' method='post'>";
            echo "<table border='1' cellspacing='0' cellpadding='5' style='margin: 20px auto; background-color:#A0CED8;'>";
            echo "<thead><tr><th class='w-20'>No</th><th class='w-20'>X</th><th class='w-20'>Y</th></tr></thead>";
            echo "<tbody>";

            for ($i = 1; $i <= $rowCount; $i++) {
                echo "<tr>";
                echo "<td class='pl-10'>{$i}</td>";
                echo "<td class='w-20'><input class='w-full p-2 rounded-md outline-[#035466]' type='number' name='nilai_x[]'
                 value='{$nilai_x[$i - 1]}' ></td>";
                echo "<td class='w-20'><input class='w-full p-2 rounded-md outline-[#035466]' type='number' name='nilai_y[]' 
                value='{$nilai_y[$i - 1]}' ></td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
            echo "<input type='hidden' name='rowCount' value='{$rowCount}'>";
            echo "<div class='flex items-center justify-center'>";
            echo "<button type='submit' name='hitung' class='mt-4 px-6 justify-center items-center py-2 bg-[#327a8a]
             text-white rounded-md hover:bg-[#035466] focus:outline-none focus:shadow-outline-blue active:bg-[#035466]'>
             Hitung</button>";
            echo "</div>";
            echo "</form>";
        } elseif (isset($_POST['generate'])) {
            echo "<p style='color: red;'>Masukkan jumlah baris yang valid (> 0).</p>";
        }
        ?>
    </div>

    <div class='w-3/5 mt-10 h-auto pb-32 mx-auto bg-[#DCF3F8]'>
        <?php
        if (isset($_POST['hitung'])) {
            $rowCount = isset($_POST['rowCount']) ? intval($_POST['rowCount']) : 0;

            if ($rowCount > 0) {
                $sumX = $sumY = $sumXY = $sumXSquare = $sumYSquare = 0;

                echo "<h1 class='font-bold text-2xl pt-6 text-center'>Tabel</h1>";
                echo "<table class='w-1/2 bg-[#A0CED8] border-collapse border border-slate-500 text-center
                 mx-auto mt-10' 
                border='1' cellspacing='0' cellpadding='5'>";
                echo "<thead ><tr><th class='border border-slate-600'>No</th><th class='border
                 border-slate-600'>X</th>
                <th class='w-20 border border-slate-600'>Y</th><th class='w-20 border border-slate-600'>XY</th>
                <th class='w-20 
                border border-slate-600'>X<sup>2</sup></th><th class='w-20 border border-slate-600'>Y<sup>2</sup>
                </th></tr></thead>";
                echo "<tbody>";

                for ($i = 1; $i <= $rowCount; $i++) {
                    $nilaiX = isset($_POST['nilai_x'][$i - 1]) ? intval($_POST['nilai_x'][$i - 1]) : 0;
                    $nilaiY = isset($_POST['nilai_y'][$i - 1]) ? intval($_POST['nilai_y'][$i - 1]) : 0;

                    $sumX += $nilaiX;
                    $sumY += $nilaiY;
                    $sumXY += $nilaiX * $nilaiY;
                    $sumXSquare += $nilaiX * $nilaiX;
                    $sumYSquare += $nilaiY * $nilaiY;

                    echo "<tr>";
                    echo "<td class='border border-slate-600'>{$i}</td>";
                    echo "<td class='border border-slate-600'>$nilaiX</td>";
                    echo "<td class='border border-slate-600'>$nilaiY</td>";
                    echo "<td class='border border-slate-600'>" . ($nilaiX * $nilaiY) . "</td>";
                    echo "<td class='border border-slate-600'>" . ($nilaiX * $nilaiX) . "</td>";
                    echo "<td class='border border-slate-600'>" . ($nilaiY * $nilaiY) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
                $b = ($rowCount * $sumXY - $sumX * $sumY) / ($rowCount * $sumXSquare - $sumX * $sumX);
                $a = ($sumY * $sumXSquare - $sumX * $sumXY) / ($rowCount * $sumXSquare - $sumX * $sumX);

                echo "<div  class='font-bold text-2xl text-center mt-10 pb-10'>";
                echo "<p>ΣX = $sumX</p>";
                echo "<p>ΣY = $sumY</p>";
                echo "<p>ΣXY = $sumXY</p>";
                echo "<p>ΣX<sup>2</sup> = $sumXSquare</p>";
                echo "<p>ΣY<sup>2</sup> = $sumYSquare</p>";
                echo "<p class='mt-10'>\\( b = \\frac{n\\Sigma XY - (\\Sigma X)(\\Sigma Y)}{n\\Sigma X^2 - (\\Sigma X)^2} = 
                \\frac{" . $rowCount . "\\times" . $sumXY . " - (" . $sumX . ")\\times(" . $sumY . ")}{" . $rowCount . 
                    "\\times" . $sumXSquare . " - (" . $sumX . ")^2} = " . number_format($b, 3) . " \\)</p>";
                echo "<p class='mt-10'>\\( a = \\frac{(\\Sigma Y)(\\Sigma X^2) - (\\Sigma X)(\\Sigma XY)}{n\\Sigma X^2 - 
                    (\\Sigma X)^2} = \\frac{" . $sumY . " \\times (" . $sumXSquare . ") - (" . $sumX . ") \\times (" . $sumXY . ")}
                    {" . $rowCount . " \\times " . $sumXSquare . " - (" . $sumX . ")^2} = " . number_format($a, 3) . " \\)</p>";
                echo "<p class='mt-10'>\\( y = a + bx \\)</p>";
                echo "<p class='mt-10'>\\(  y = " . number_format($a, 3) . " + " . number_format($b, 3) . " x \\)</p>";
                echo "</div>";
            } else {
                echo "<p style='color: red;'>Masukkan jumlah baris yang valid (> 0).</p>";
            }

            echo "<h1 class='font-bold text-2xl pt-6 text-center'>Grafik</h1>";
            echo "<canvas style='width: 300px; height: 150px; margin-left:200px ; margin-right:200px ; margin-top:20px ; border-radius:
             10px; background: #A0CED8;' id='regressionChart' width='800' height='400'></canvas>";
            echo "<script>";
            echo "var ctx = document.getElementById('regressionChart').getContext('2d');";
            echo "var xValues = [" . implode(',', $nilai_x) . "];";
            echo "var yValues = [" . implode(',', $nilai_y) . "];";
            echo "var regressionLine = [" . implode(',', array_map(function ($x) use ($a, $b) {
                return $a + $b * $x;
            }, $nilai_x)) . "];";
            echo "var myChart = new Chart(ctx, {";
            echo "type: 'scatter',";
            echo "data: {";
            echo "datasets: [{";
            echo "label: 'Data',";
            echo "data: Array.from({length: xValues.length}, (_, i) => ({x: xValues[i], y: yValues[i]})),";
            echo "backgroundColor: 'rgba(75, 192, 192, 0.2)',";
            echo "pointRadius: 8,";
            echo "pointHoverRadius: 10,";
            echo "}, {";
            echo "type: 'line',";
            echo "label: 'Regresi Linear',";
            echo "data: Array.from({length: xValues.length}, (_, i) => ({x: xValues[i], y: regressionLine[i]})),";
            echo "borderColor: 'rgba(255, 99, 132, 1)',";
            echo "backgroundColor: 'rgba(255, 99, 132, 0.2)',";
            echo "borderWidth: 2,";
            echo "}, {";
            echo "type: 'line',";
            echo "label: 'Garis Data',";
            echo "data: Array.from({length: xValues.length}, (_, i) => ({x: xValues[i], y: yValues[i]})),";
            echo "borderColor: 'rgba(0, 0, 255, 1)',";
            echo "backgroundColor: 'rgba(0, 0, 255, 0.2)',";
            echo "borderWidth: 2,";
            echo "}],";
            echo "},";
            echo "options: {";
            echo "scales: {";
            echo "x: {";
            echo "type: 'linear',";
            echo "position: 'bottom',";
            echo "},";
            echo "y: {";
            echo "type: 'linear',";
            echo "position: 'left',";
            echo "},";
            echo "},";
            echo "},";
            echo "});";
            echo "</script>";

            $jkt = $sumYSquare - ($sumY * $sumY)/ $rowCount;
            $jkr = $b * ($sumXY- $sumX * $sumY / $rowCount);
            $jkg = $jkt - $jkr;

            $dbT = $rowCount - 1;
            $dbR = 1;
            $dbG = $dbT -$dbR;

            $KTR = $jkr / $dbR;
            $KTG = $jkg / $dbG;

            $F = $KTR / $KTG ;
            
            $alpha = 0.05;

            echo "<h1 class='font-bold text-2xl pt-10 text-center'>Tabel Anova</h1>";
            echo "<table class='w-1/2 bg-[#A0CED8] border-collapse border border-slate-500 text-center mx-auto mt-5' border='1' 
            cellspacing='0' cellpadding='5'>";
            echo "<thead ><tr><th class='border border-slate-600'>SK</th><th class='border border-slate-600'>JK</th><th 
            class='w-20 border border-slate-600'>db</th><th class='w-20 border border-slate-600'>KT</th><th class='w-20
             border border-slate-600'>F<sub>hitung</sub></th><th class='w-20 border border-slate-600'>F<sub>tabel 0,05</sub>
             </th></tr></thead>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td class='border border-slate-600'>Regresi</td>";
                echo "<td class='border border-slate-600'>". number_format($jkr, 3). "</td>";
                echo "<td class='border border-slate-600'>$dbR</td>";
                echo "<td class='border border-slate-600'>". number_format($KTR, 3). "</td>";
                echo "<td class='border border-slate-600'>$F</td>";
                echo "<td class='border border-slate-600'>F<sub>tabel$alpha</sub>($dbR;$dbG)</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='border border-slate-600'>Galat</td>";
                echo "<td class='border border-slate-600'>". number_format($jkg, 3). "</td>";
                echo "<td class='border border-slate-600'>$dbG</td>";
                echo "<td class='border border-slate-600'>". number_format($KTG, 3). "</td>";
                echo "<td class='border border-slate-600'></td>";
                echo "<td class='border border-slate-600'></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='border border-slate-600'>Total</td>";
                echo "<td class='border border-slate-600'>". number_format($jkt, 3). "</td>";
                echo "<td class='border border-slate-600'>$dbT</td>";
                echo "<td class='border border-slate-600'></td>";
                echo "<td class='border border-slate-600'></td>";
                echo "<td class='border border-slate-600'></td>";
                echo "</tr>";
            echo "</tbody></table>";
            echo "<div class='flex justify-center items-center'>";
            echo "<a href='http://ledhyane.lecture.ub.ac.id/files/2013/07/tabel-f-0-05.pdf'><button class=' mx-auto my-auto 
            mt-4 px-6   py-2 bg-[#327a8a] text-white rounded-md hover:bg-[#035466] focus:outline-none focus:shadow-outline-blue 
            active:bg-[#035466]'>Klik Untuk Melihat Nilai F<sub>tabel</sub></button></a>";
            echo "</div>";
        }
        ?>
    </div>
    <footer class='h-96 flex mt-10 justify-center w-full bg-[#74AFBC] relative bottom-0'>
        <h1 class='text-xl text-white pt-10 pb-10 font-bold text-center'>Copyright © 2023 - Febriandi | 2101020062 
            <br>Fakultas Teknik dan Teknologi Kemaritiman <br>Universitas Maritim Raja Ali Haji</h1>
    </footer>
</body>

</html>