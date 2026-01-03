<?php 

$_perk_discord = "Access Discord Text Channel for Supporters";
$_perk_iriam_1 = "View/Download IRIAM<br> ";
$_perk_iriam_2 = "★ Star<br>Fan Badge Rewards";
$_perk_blog    = "Read Browntul's Blog";
$_perk_karaoke = "Listen to Tank Engine Karaoke On-Demand";
$_perk_letter =  "Receive a Handwritten Digital Letter";
$_perk_personal= "Receive A Custom Personalized Reward";
$_perk_emotes  = "Use Twitch-exclusive Emotes";


?>


<div class="container rounded bg-dark text-white" style="margin:0">
    <div class="row">
        <div class="col">
            <center><img src="https://res.cloudinary.com/browntulstar/image/private/s--ZPURbd45--/c_pad,w_200,h_200,ar_1:1/f_webp/v1/com.browntulstar/img/turtle-adult?_a=BAAAUWGX" style="width:100%;max-width:200px" /></center><br/>
            <h2 class="text-center mb-2">Perks Chart</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div style="overflow-x:auto">
                <table class="table table-fixed table-hover table-striped table-bordered table-dark" style="text-align:center">
                    <thead class="table-light">
                        <tr>
                        <th scope="col"><span class="badge bg-danger w-100">RED SHELLS<br/>(Twitch Subs)</span></th>
                        <th scope="col"><span class="badge bg-info w-100">STARS<br/>(IRIAM 1★)</span></th>
                        <th scope="col"><span class="badge bg-info w-100">SUPER STARS<br/>(IRIAM 2★)</span></th>
                        <th scope="col"><span class="badge bg-info w-100">GRAND STARS<br/>(IRIAM 3★)</span></th>
                        <th scope="col"><span class="badge bg-warning w-100">GOLD SHELLS<br/>(Discord VIPs)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td class="table-danger">Active Until:<br>30 days since purchase</td>
                        <td class="table-info">Active Until:<br>Dec 31st, 2026 at 11:59pm PST</td>
                        <td class="table-info">Active Until:<br>5th day of month after badge earned</td>
                        <td class="table-info">Active Until:<br>5th day of month after badge earned</td>
                        <td class="table-warning">Active Until:<br>-</td>
                        </tr>
                        <tr>
                        <td class="table-danger"><?=$_perk_discord ?></td>
                        <td class="table-info"><?=$_perk_discord ?></td>
                        <td class="table-info"><?=$_perk_discord ?></td>
                        <td class="table-info"><?=$_perk_discord ?></td>
                        <td class="table-warning"><?=$_perk_discord ?></td>
                        </tr>
                        <tr>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td class="table-info"><?=$_perk_iriam_1 . "1" . $_perk_iriam_2 ?></td>
                        <td class="table-info"><?=$_perk_iriam_1 . "1/2" . $_perk_iriam_2 ?></td>
                        <td class="table-info"><?=$_perk_iriam_1 . "1/2/3" . $_perk_iriam_2 ?></td>
                        <td class="table-warning"><?=$_perk_iriam_1 . "1/2" . $_perk_iriam_2 ?></td>
                        </tr>
                        <td class="table-danger"><?=$_perk_blog ?></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td class="table-info"><?=$_perk_blog ?></td>
                        <td class="table-info"><?=$_perk_blog ?></td>
                        <td class="table-warning"><?=$_perk_blog ?></td>
                        </tr>
                        <td class="table-danger"><?=$_perk_karaoke ?></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td class="table-info"><?=$_perk_karaoke ?></td>
                        <td class="table-info"><?=$_perk_karaoke ?></td>
                        <td class="table-warning"><?=$_perk_karaoke ?></td>
                        </tr>
                        <tr>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td class="table-info"><?=$_perk_letter ?></i></td>
                        <td class="table-info"><?=$_perk_letter ?></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        </tr>
                        <tr>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td class="table-info"><?=$_perk_personal ?></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        </tr>
                        <tr>
                        <td class="table-danger"><?=$_perk_emotes ?></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        <td><i class="fa-solid fa-minus"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p><small><strong>Fine print:</strong>
            <ul>
                <li><strong>IRIAM:</strong> The IRIAM 1★ role gained on or after January 1st, 2026 at 12:00am PST will remain assigned to the corresponding Discord user until the end of 2026.
                 IRIAM 2★ and IRIAM 3★ roles gained for a given month reset at the 5th of the following month regardless of when they are achieved or verified.
                    Roles can be gained at the start of each month
                in accordance to IRIAM's monthly calendar system. It may not be possible to achieve IRIAM 2★ or IRIAM 3★
            in a given month; please spend responsibly. The "Secret Personalized Reward" is
            determined solely by Browntul if IRIAM 3★ is achieved.
                <li><strong>Twitch/VIP:</strong> Twitch subs and VIP last approximately 30 days
            from the day your role is earned, with a grace period of 3 days after the subscription or special perk
            expires if a Discord login is used to access perks.
                <li><strong>All Content:</strong> New content for "Browntul's Blog" and "Tank Engine Karaoke" is not guaranteed per month.
            </ul>
            </small></p>
        </div>
    </div>
</div>