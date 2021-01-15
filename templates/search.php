<div class="container">
    <?php if (!empty($search)): ?>
        <section class="ads">
          <h2 class="ads__header">Search results for the query «<span><?=$search; ?></span>»</h2>
              <?php if (!count($ads)): ?>
                <p>Nothing was found for your search query</p>
              <?php else: ?>
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
        <?php endif; ?>
    <?php else: ?>
        <h2>You didn't enter the request</h2>
    <?php endif; ?>
  </div>
