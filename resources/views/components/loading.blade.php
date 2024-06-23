@props(['variant'])
<div class="{{ isset($variant) ? 'loader ' . $variant : 'loader' }}">
    <div class="loader__circle"></div>
    <div class="loader__circle"></div>
</div>
