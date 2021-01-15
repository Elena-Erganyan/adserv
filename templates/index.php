<section class="ads">
    <h2 class="ads__header">All ads</h2>
    <ul class="ads__list">
        <? while ($ad = mysqli_fetch_assoc($ads)): ?>
        <li class="ad">
            <div class="ad__photo">
                <img src="<?= $ad['img']; ?>" width="170" alt="<?=$ad['title']; ?>">
            </div>
            <div class="ad__wrapper">
                <div class="ad__title"><a href="ad.php?id=<?=$ad["id"]; ?>"><?= $ad['title']; ?></a></div>
                <div class="ad__price"><?= $ad['price']; ?> &#8399;</div>
            </div>
        </li>
        <? endwhile; ?>
    </ul>
</section>
<div class="pagination"><?=$pagination; ?></div>