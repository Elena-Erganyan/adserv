<div class="container">
  <section class="ads">
    <h2 class="ads__header">All ads in category <span class="ads__category"><?=$ads[0]["cat_name"]; ?></span></h2>
    <ul class="ads__list">
        <? foreach($ads as $ad): ?>
        <li class="ad">
            <div class="ad__photo">
                <img src="<?= $ad['img']; ?>" width="170" alt="<?=$ad['title']; ?>">
            </div>
            <div class="ad__wrapper">
                <div class="ad__title"><a href="ad.php?id=<?=$ad["id"]; ?>"><?= $ad['title']; ?></a></div>
                <div class="ad__price"><?= $ad['price']; ?> &#8399;</div>
            </div>
        </li>
        <? endforeach; ?>
    </ul>
  </section>
  <div class="pagination"><?=$pagination; ?></div>
</div>
