<ul class="socials">
    @if($socialLinks)
    @if($socialLinks->youtube)
    <li><a href="{{ $socialLinks->youtube }}">  <i class="fa-brands fa-youtube"></i></li></a>
    @endif
    @if($socialLinks->facebook)
    <li><a href="{{ $socialLinks->facebook }}">  <i class="fa-brands fa-facebook"></i></li></a>
    @endif
    @if($socialLinks->instagram)
    <li><a href="{{ $socialLinks->instagram }}">  <i class="fa-brands fa-instagram"></i></li></a>
    @endif
    @if($socialLinks->ticktock)
    <li><a href="{{ $socialLinks->ticktock }}">  <i class="fa-brands fa-tiktok"></i></li></a>
    @endif
    @if($socialLinks->linkedin)
    <li><a href="{{ $socialLinks->linkedin }}">  <i class="fa-brands fa-linkedin"></i></li></a>
    @endif
    @if($socialLinks->github)
    <li><a href="{{ $socialLinks->github }}">  <i class="fa-brands fa-github"></i></li></a>
    @endif
  @endif
  </ul>
