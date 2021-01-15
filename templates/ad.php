<?php if (isset($ad)): ?>
<section class="ad-item">
    <h2 class="ads__header"><?=strip_tags($ad["title"]); ?></h2>
    <div class="ad-item__content">
        <div class="ad-item__left">
            <div class="ad-item__image">
                <img src="<?=strip_tags("./" . $ad["img"]); ?>" width="500" alt="<?=strip_tags("./" . $ad["img"]); ?>">
            </div>
            <p class="ad-item__description"><?=$ad["description"] ?? ""; ?></p>
        </div>
        <div class="ad-item__right">
            <div class="ad-item__price">
                <span class="ad-item__amount">Price</span>
                <span class="ad-item__cost"><?=$ad["price"]; ?> &#8399;</span>
            </div>
            <?php if (isset($user) && !$is_ad_author): ?>
            <div class="ad-item__phone">
                <div>Contact with the ad's author</div>
                <a href="tel:<?=$ad["phone"]; ?>"><?=$ad["phone"]?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php else: ?>
    <h1>An ad with this id was not found</h1>
<?php endif; ?>