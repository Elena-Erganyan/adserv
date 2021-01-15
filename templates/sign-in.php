<?php $classname = (count($errors)) ? "form--invalid" : ""; ?>
<form class="form container <?=$classname; ?>" action="sign-in.php" method="post"> <!-- form--invalid -->
    <h2>Sign in</h2>

    <?php $classname = isset($errors["email"]) ? "form__item--invalid" : "";
      $value = $form["email"] ?? "";
      $message = $errors["email"] ?? ""; ?>

    <div class="form__item <?=$classname; ?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Enter e-mail" value="<?=$value; ?>">
      <span class="form__error"><?=$message; ?></span>
    </div>

    <?php $classname = isset($errors["password"]) ? "form__item--invalid" : "";
      $value = $form["password"] ?? "";
      $message = $errors["password"] ?? ""; ?>

    <div class="form__item form__item--last <?=$classname; ?>">
      <label for="password">Password*</label>
      <input id="password" type="password" name="password" placeholder="Enter password" value="<?=$value; ?>">
      <span class="form__error"><?=$message; ?></span>
    </div>
    <button type="submit" class="btn">Sign in</button>
</form>