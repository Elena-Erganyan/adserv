<?php if (isset($user)): ?>
<section class="my-ads">
    <h2 class="my-ads__header ads__header">My ads</h2>
    <?php if(count($my_ads)): ?>
    <table class="my-ads__list">
      <? foreach ($my_ads as $item): ?>
      <tr class="my-ads__item item">
        <td class="item__img">
            <img src="<?=$item["img"]; ?>" width="60" alt="<?=$item["ad_title"]; ?>">
        </td>
        <td class="item__title">
          <h3><a href="ad.php?id=<?=$item["id"]; ?>"><?=$item["ad_title"]; ?></a></h3>
        </td>
        <td class="item__price">
          <?=$item["price"]; ?>  &#8399;
        </td>
        <td class="item__edit">
          <a href="edit.php?id=<?=$item["id"]; ?>">Edit</a>
        </td>
        <td class="item__delete">
          <a href="delete.php?id=<?=$item["id"]; ?>">Delete</a>
        </td>
      </tr>
      <? endforeach; ?>
    </table>
    <?php else: ?>
        <p>You don't have any ads yet</p>
    <?php endif; ?>
</section>
<?php else: ?>
    <h1>Error 403: Access denied</h1>
<?php endif; ?>
