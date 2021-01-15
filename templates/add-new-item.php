<?php if (isset($user)): ?>
<?php $classname = count($errors) ? "form--invalid" : "" ; ?>
<h2 class="ads__header">Adding a new ad</h2>
<form class="form form--add <?=$classname; ?>" action="./add-new-item.php" method="post" enctype="multipart/form-data">
    
    <div class="form__container-two">

      <?php $classname = isset($errors["title"]) ? "form__item--invalid" : "";
      $value = $ad["title"] ?? "";
      $message = $errors["title"] ?? ""; ?>

      <div class="form__item <?=$classname; ?>">
        <label for="title">Title*</label>
        <input id="title" type="text" name="title" placeholder="Enter the name of the ad" value="<?=$value; ?>">
        <span class="form__error"><?=$message; ?></span>
      </div>

      <?php $classname = isset($errors["category"]) ? "form__item--invalid" : "";
       $value = $ad["category"] ?? "";
       $message = $errors["category"] ?? ""; ?>

      <div class="form__item <?=$classname; ?>">
        <label for="category">Category*</label>
        <select id="category" name="category">
          <option>Select a category</option>
          <? foreach($categories as $category) : ?>
          <?php $selected = ($value == $category["name"]) ? "selected" : ""; ?>
          <option <?=$selected; ?>><?=$category["name"]; ?></option>
          <? endforeach; ?>
        </select>
        <span class="form__error"><?=$message; ?></span>
      </div>
    </div>

    <?php $classname = isset($errors["description"]) ? "form__item--invalid" : "";
    $value = $ad["description"] ?? "";
    $message = $errors["description"] ?? ""; ?>

    <div class="form__item form__item--wide <?=$classname; ?>">
      <label for="description">Description*</label>
      <textarea id="description" name="description" placeholder="Enter a description"><?=$value; ?></textarea>
      <span class="form__error"><?=$message; ?></span>
    </div>

    <?php $classname = !isset($ad["img"]) ? "form__item--invalid" : "form__item--uploaded";
    $message = $errors["img"] ?? "";
    $img = $ad["img"] ?? ""; ?>
    <div class="form__item form__item--file <?=$classname; $uploaded; ?>">
      <label>Image</label>
      <div class="form__input-file" id="file">
        <input class="visually-hidden" type="file" name="img" id="img" value="<?=$img;?>">
        <label class="btn btn--light" id="imgLabel" for="img"><span>+ Add an image</span></label>
        <div class="preview" id="preview"></div>
        <span class="form__error"><?=$message; ?></span>
      </div>
    </div>

    <div class="form__container-three">

      <?php $classname = isset($errors["price"]) ? "form__item--invalid" : "";
      $value = $ad["price"] ?? "";
      $message = $errors["price"] ?? ""; ?>

      <div class="form__item form__item--small <?=$classname; ?>">
        <label for="price">Price*, rub.</label>
        <input id="price" type="number" name="price" placeholder="0" value="<?=$value; ?>">
        <span class="form__error"><?=$message; ?></span>
      </div>
    </div>

    <?php $message = count($errors) ? "Please correct the errors in the form" : "" ; ?>
    <span class="form__error form__error--bottom"><?=$message; ?></span>
    <button class="form__btn btn" type="submit">Add an ad</button>
</form>
<?php else: ?>
    <h1>Error 403: Access denied</h1>
<?php endif; ?>
