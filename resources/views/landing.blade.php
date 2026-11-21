<!DOCTYPE html>

<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta content="#071A45" name="theme-color" />
  <meta content="Prudence Healthcare Growth Consultancy — Marketing Automation: A Game Changer For Hybrid Marketing."
    name="description" />
  <title>Prudence | Healthcare Growth Consultancy</title>
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('website/assets/favicon.png') }}">
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
    rel="stylesheet" />
  <style>
    :root {
      --navy: #071A45;
      --navy2: #4B18C9;
      --blue: #0788ED;
      --cyan: #20D5EF;
      --pink: #8B2BE2;
      --lime: #00B7A8;
      --ink: #17213d;
      --muted: #68738d;
      --line: #e7ebf4;
      --paper: #f7f9fd;
      --white: #fff;
      --gradient: linear-gradient(112deg, #071A45 0%, #1746A2 52%, #0788ED 100%);
      --shadow: 0 24px 70px rgba(19, 35, 91, .12)
    }

    * {
      box-sizing: border-box
    }

    html {
      scroll-behavior: smooth;
      scroll-padding-top: 100px
    }

    body {
      margin: 0;
      background: #fff;
      color: var(--ink);
      font-family: 'Manrope', sans-serif;
      line-height: 1.65
    }

    a {
      color: inherit;
      text-decoration: none
    }

    img {
      max-width: 100%;
      display: block
    }

    button {
      font: inherit
    }

    .site-loader {
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: #fff;
      display: grid;
      place-items: center;
      transition: opacity .65s ease, visibility .65s ease
    }

    .site-loader.hide {
      opacity: 0;
      visibility: hidden;
      pointer-events: none
    }

    .loader-inner {
      width: min(360px, 78vw);
      display: grid;
      justify-items: center;
      gap: 20px
    }

    .loader-inner img {
      width: 100%;
      animation: logoFloat 1.8s ease-in-out infinite
    }

    .loader-track {
      height: 3px;
      width: 65%;
      background: #e7edf8;
      border-radius: 10px;
      overflow: hidden
    }

    .loader-track span {
      height: 100%;
      width: 36%;
      display: block;
      background: linear-gradient(90deg, #071A45, #0788ED);
      animation: load 1.3s ease-in-out infinite
    }

    .loader-inner small {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      font-weight: 800;
      color: #74809b
    }

    @keyframes load {
      from {
        transform: translateX(-110%)
      }

      to {
        transform: translateX(290%)
      }
    }

    @keyframes logoFloat {
      50% {
        transform: translateY(-5px);
        opacity: .85
      }
    }

    .topline {
      background: #101444;
      color: #dfe8ff;
      font-size: 11px;
      letter-spacing: .5px
    }

    .topline .wrap {
      max-width: 1240px;
      margin: auto;
      padding: 9px 24px;
      display: flex;
      justify-content: space-between;
      gap: 12px
    }

    header {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255, 255, 255, .93);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid rgba(20, 35, 90, .08)
    }

    .nav {
      max-width: 1240px;
      margin: auto;
      padding: 10px 24px;
      min-height: 88px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px
    }

    .brand img {
      width: 265px;
      height: 74px;
      object-fit: contain;
      object-position: left center
    }

    .navlinks {
      display: flex;
      align-items: center;
      gap: 25px;
      font-size: 12px;
      font-weight: 800;
      color: #3b4662
    }

    .navlinks a {
      transition: color .2s
    }

    .navlinks a:hover {
      color: var(--blue)
    }

    .navbtn,
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      border: 0;
      border-radius: 999px;
      background: var(--gradient);
      color: white;
      padding: 13px 21px;
      font-size: 12px;
      font-weight: 800;
      box-shadow: 0 12px 28px rgba(13, 79, 164, .2);
      transition: transform .25s, box-shadow .25s
    }

    .navbtn:hover,
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 17px 34px rgba(13, 79, 164, .27)
    }

    .menu {
      display: none;
      border: 0;
      background: #eef5ff;
      border-radius: 12px;
      padding: 10px 13px;
      font-size: 21px;
      color: var(--navy)
    }

    .wrap {
      width: min(1240px, calc(100% - 48px));
      margin: auto
    }

    .hero {
      position: relative;
      overflow: hidden;
      background: radial-gradient(circle at 82% 18%, rgba(41, 184, 237, .2), transparent 28%), linear-gradient(135deg, #f7f9ff 0%, #fff 48%, #eef8ff 100%);
      padding: 84px 0 90px
    }

    .hero:before {
      content: "";
      position: absolute;
      width: 560px;
      height: 560px;
      border: 1px solid rgba(7, 156, 219, .13);
      border-radius: 50%;
      right: -180px;
      top: -240px;
      box-shadow: 0 0 0 45px rgba(7, 156, 219, .025), 0 0 0 95px rgba(7, 156, 219, .02)
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1.05fr .95fr;
      align-items: center;
      gap: 54px;
      position: relative
    }

    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 9px;
      color: #4B18C9;
      background: #F1F4FF;
      border: 1px solid #DDEBFF;
      border-radius: 99px;
      padding: 8px 13px;
      font-size: 10px;
      font-weight: 800;
      letter-spacing: 1.5px;
      text-transform: uppercase
    }

    .eyebrow:before {
      content: "";
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--blue);
      box-shadow: 0 0 0 5px rgba(7, 156, 219, .1)
    }

    h1,
    h2,
    h3,
    h4 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      letter-spacing: -.04em
    }

    .hero h1 {
      font-size: clamp(42px, 5vw, 67px);
      line-height: 1.08;
      margin: 24px 0 20px;
      color: var(--navy);
      max-width: 720px
    }

    .hero h1 span {
      background: var(--gradient);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent
    }

    .hero p {
      font-size: 16px;
      color: #62708c;
      max-width: 590px;
      line-height: 1.9
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 13px;
      margin-top: 28px
    }

    .btn-outline {
      background: #fff;
      color: var(--navy);
      border: 1px solid #dfe7f4;
      box-shadow: none
    }

    .hero-visual {
      position: relative;
      background: #fff;
      border: 1px solid #e6edf7;
      border-radius: 30px;
      padding: 13px;
      box-shadow: var(--shadow);
      transform: perspective(1000px) rotateY(-5deg);
      animation: float 6s ease-in-out infinite
    }

    .hero-visual img {
      width: 100%;
      border-radius: 20px
    }

    .float-pill {
      position: absolute;
      left: -25px;
      bottom: 26px;
      background: #fff;
      padding: 14px 18px;
      border-radius: 15px;
      box-shadow: 0 14px 36px rgba(20, 40, 90, .15);
      font-size: 11px;
      font-weight: 800;
      color: var(--navy)
    }

    .float-pill span {
      display: block;
      color: var(--blue);
      font-size: 19px;
      font-family: 'Plus Jakarta Sans'
    }

    @keyframes float {

      0%,
      100% {
        transform: perspective(1000px) rotateY(-5deg) translateY(0)
      }

      50% {
        transform: perspective(1000px) rotateY(-3deg) translateY(-10px)
      }
    }

    .trustbar {
      background: #fff;
      border-bottom: 1px solid var(--line)
    }

    .trustrow {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0
    }

    .trustitem {
      padding: 22px 15px;
      text-align: center;
      border-right: 1px solid var(--line)
    }

    .trustitem:last-child {
      border: 0
    }

    .trustitem b {
      display: block;
      font: 800 16px 'Plus Jakarta Sans';
      color: var(--navy)
    }

    .trustitem small {
      font-size: 10px;
      color: var(--muted);
      letter-spacing: .8px;
      text-transform: uppercase
    }

    .section {
      padding: 92px 0
    }

    .section.soft {
      background: var(--paper)
    }

    .section.dark {
      background: linear-gradient(125deg, #071A45, #1746A2 58%, #4B18C9);
      color: #fff
    }

    .section-head {
      max-width: 760px;
      margin: 0 auto 45px;
      text-align: center
    }

    .section-head .eyebrow {
      margin-bottom: 15px
    }

    .section-head h2 {
      font-size: clamp(30px, 4vw, 45px);
      line-height: 1.15;
      margin: 0 0 14px;
      color: var(--navy)
    }

    .dark .section-head h2 {
      color: #fff
    }

    .section-head p {
      color: var(--muted);
      font-size: 14px
    }

    .dark .section-head p {
      color: #d5e3ff
    }

    .pillar-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px
    }

    .pillar {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 19px;
      padding: 24px;
      box-shadow: 0 8px 25px rgba(22, 40, 90, .04);
      transition: .3s
    }

    .pillar:hover {
      transform: translateY(-7px);
      box-shadow: var(--shadow)
    }

    .pillar .num {
      width: 39px;
      height: 39px;
      border-radius: 12px;
      background: #F1F4FF;
      color: #0788ED;
      display: grid;
      place-items: center;
      font-weight: 900;
      margin-bottom: 17px
    }

    .pillar h3 {
      font-size: 17px;
      color: var(--navy);
      margin: 0 0 9px
    }

    .pillar p {
      font-size: 12px;
      color: var(--muted);
      margin: 0;
      line-height: 1.8
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px
    }

    .feature {
      display: flex;
      gap: 13px;
      align-items: flex-start;
      padding: 18px;
      border: 1px solid var(--line);
      background: #fff;
      border-radius: 15px
    }

    .feature-icon {
      flex: 0 0 38px;
      width: 38px;
      height: 38px;
      border-radius: 12px;
      background: linear-gradient(135deg, #F1F4FF, #F3EFFF);
      display: grid;
      place-items: center;
      color: #0788ED;
      font-weight: 900
    }

    .feature b {
      display: block;
      font-size: 13px;
      color: var(--navy)
    }

    .feature small {
      font-size: 11px;
      color: var(--muted)
    }

    .apps-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 18px
    }

    .app-card {
      padding: 26px;
      border-radius: 20px;
      background: #fff;
      border: 1px solid var(--line);
      transition: .3s
    }

    .app-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow)
    }

    .app-card .appno {
      font-size: 10px;
      letter-spacing: 1.5px;
      font-weight: 900;
      color: #0788ED
    }

    .app-card h3 {
      font-size: 19px;
      color: var(--navy);
      margin: 7px 0 14px
    }

    .app-card ul {
      padding-left: 17px;
      margin: 0;
      color: #64708b;
      font-size: 12px;
      line-height: 2.05
    }

    .metrics {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px
    }

    .metric {
      padding: 22px;
      border-radius: 18px;
      background: rgba(255, 255, 255, .09);
      border: 1px solid rgba(255, 255, 255, .15)
    }

    .metric strong {
      font: 800 clamp(22px, 3vw, 34px) 'Plus Jakarta Sans';
      display: block;
      color: #152f78
    }

    .metric span {
      font-size: 11px;
      color: #fb138c
    }

    .slide-list {
      display: grid;
      gap: 22px
    }

    .slide-card {
      display: grid;
      grid-template-columns: .92fr 1.08fr;
      gap: 30px;
      align-items: center;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 24px;
      padding: 24px;
      box-shadow: 0 8px 26px rgba(20, 40, 90, .045);
      scroll-margin-top: 110px
    }

    .slide-card:nth-child(even) .slide-copy {
      order: 2
    }

    .slide-card:nth-child(even) .slide-preview {
      order: 1
    }

    .slide-kicker {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 1.4px;
      color: #71809c;
      font-weight: 900
    }

    .slide-kicker span:first-child {
      color: #0788ED
    }

    .slide-kicker i {
      width: 25px;
      height: 1px;
      background: #b9c9e1
    }

    .slide-copy h3 {
      font-size: clamp(22px, 2.4vw, 30px);
      color: var(--navy);
      line-height: 1.2;
      margin: 14px 0 17px
    }

    .slide-text {
      display: grid;
      gap: 9px
    }

    .content-line {
      font-size: 12px;
      line-height: 1.65;
      color: #596782;
      white-space: normal
    }

    .slide-text .content-line:not(:first-child) {
      padding-top: 0
    }

    .slide-preview {
      position: relative;
      border-radius: 16px;
      overflow: hidden;
      background: #eef3fa;
      border: 1px solid #e2e9f4;
      box-shadow: 0 14px 32px rgba(15, 35, 80, .1)
    }

    .slide-preview img {
      width: 100%;
      aspect-ratio: 16/9;
      object-fit: contain;
      background: #f4f6fa;
      transition: transform .5s
    }

    .slide-preview:hover img {
      transform: scale(1.025)
    }

    .preview-tag {
      position: absolute;
      left: 12px;
      bottom: 12px;
      background: rgba(16, 23, 70, .86);
      color: #fff;
      border-radius: 99px;
      padding: 7px 12px;
      font-size: 10px;
      font-weight: 800;
      backdrop-filter: blur(8px)
    }

    .preview-tag b {
      margin-left: 8px;
      color: #6bd3ff
    }

    .data-block {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      align-items: start
    }

    .data-panel {
      background: #fff;
      color: var(--ink);
      border-radius: 20px;
      padding: 27px
    }

    .data-panel h3 {
      margin: 0 0 16px;
      color: var(--navy);
      font-size: 20px
    }

    .data-panel p {
      font-size: 12px;
      color: var(--muted)
    }

    .chip-list {
      display: flex;
      flex-wrap: wrap;
      gap: 9px
    }

    .chip {
      background: #F3EFFF;
      border: 1px solid #E4DDFF;
      color: #3920A5;
      border-radius: 99px;
      padding: 8px 12px;
      font-size: 11px;
      font-weight: 800
    }

    .reference-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 13px
    }

    .reference-tile {
      border-radius: 14px;
      overflow: hidden;
      background: #fff;
      border: 1px solid var(--line);
      position: relative
    }

    .reference-tile img {
      width: 100%;
      aspect-ratio: 1/1;
      object-fit: cover;
      transition: transform .4s
    }

    .reference-tile:hover img {
      transform: scale(1.06)
    }

    .reference-tile span {
      display: block;
      padding: 8px 10px;
      font-size: 10px;
      font-weight: 800;
      color: var(--navy)
    }

    .cta {
      padding: 65px 0;
      background: radial-gradient(circle at 90% 10%, rgba(44, 184, 238, .22), transparent 30%), var(--gradient);
      color: #fff
    }

    .cta-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 25px
    }

    .cta h2 {
      font-size: clamp(28px, 4vw, 42px);
      margin: 0 0 8px
    }

    .cta p {
      margin: 0;
      color: #d9e7ff;
      font-size: 13px
    }

    .cta .btn {
      background: #fff;
      color: var(--navy);
      box-shadow: none;
      white-space: nowrap
    }

    footer {
      background: #0c103d;
      color: #d7dff6;
      padding: 52px 0 22px
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 1.4fr 1fr 1fr;
      gap: 35px;
      padding-bottom: 35px
    }

    .footer-logo {
      width: 245px;
      background: #fff;
      padding: 7px;
      border-radius: 10px
    }

    footer p,
    footer a {
      font-size: 12px;
      color: #b8c5e5;
      line-height: 1.9
    }

    footer h4 {
      color: #fff;
      font-size: 13px
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, .12);
      padding-top: 18px;
      font-size: 10px;
      color: #aab7d7;
      display: flex;
      justify-content: space-between;
      gap: 15px
    }

    .reveal {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity .7s ease, transform .7s cubic-bezier(.2, .7, .2, 1)
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0)
    }

    .reveal:nth-child(3n+2) {
      transition-delay: .08s
    }

    .reveal:nth-child(3n) {
      transition-delay: .14s
    }

    @media(max-width:980px) {
      .navlinks {
        gap: 15px
      }

      .navlinks a {
        font-size: 11px
      }

      .brand img {
        width: 225px
      }

      .hero-grid {
        gap: 30px
      }

      .pillar-grid {
        grid-template-columns: repeat(2, 1fr)
      }

      .apps-grid {
        grid-template-columns: repeat(2, 1fr)
      }

      .feature-grid {
        grid-template-columns: repeat(2, 1fr)
      }

      .reference-grid {
        grid-template-columns: repeat(4, 1fr)
      }
    }

    @media(max-width:760px) {
      .topline .wrap {
        justify-content: center;
        text-align: center
      }

      .topline .wrap span:last-child {
        display: none
      }

      .nav {
        min-height: 75px;
        padding: 8px 18px
      }

      .brand img {
        width: 190px;
        height: 57px
      }

      .menu {
        display: block
      }

      .navlinks {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        padding: 18px 22px 24px;
        box-shadow: 0 18px 25px rgba(10, 30, 80, .1);
        flex-direction: column;
        align-items: stretch;
        gap: 0
      }

      .navlinks.open {
        display: flex
      }

      .navlinks a {
        padding: 12px 4px;
        border-bottom: 1px solid #eef1f6;
        font-size: 13px
      }

      .navlinks .navbtn {
        margin-top: 14px;
        text-align: center
      }

      .wrap {
        width: min(100% - 36px, 600px)
      }

      .hero {
        padding: 60px 0
      }

      .hero-grid {
        grid-template-columns: 1fr
      }

      .hero h1 {
        font-size: clamp(38px, 10vw, 54px)
      }

      .hero-visual {
        transform: none;
        max-width: 560px;
        margin: 10px auto 0
      }

      .float-pill {
        left: 8px;
        bottom: 10px
      }

      .trustrow {
        grid-template-columns: repeat(2, 1fr)
      }

      .trustitem:nth-child(2) {
        border-right: 0
      }

      .trustitem:nth-child(-n+2) {
        border-bottom: 1px solid var(--line)
      }

      .section {
        padding: 68px 0
      }

      .slide-card {
        grid-template-columns: 1fr;
        padding: 17px;
        gap: 20px
      }

      .slide-card:nth-child(even) .slide-copy,
      .slide-card:nth-child(even) .slide-preview {
        order: initial
      }

      .slide-copy h3 {
        font-size: 24px
      }

      .data-block {
        grid-template-columns: 1fr
      }

      .cta-inner {
        align-items: flex-start;
        flex-direction: column
      }

      .footer-grid {
        grid-template-columns: 1fr 1fr
      }

      .footer-grid>div:first-child {
        grid-column: 1/-1
      }
    }

    @media(max-width:480px) {
      .brand img {
        width: 168px;
        height: 52px
      }

      .hero-actions .btn {
        width: 100%
      }

      .pillar-grid,
      .apps-grid,
      .feature-grid {
        grid-template-columns: 1fr
      }

      .metrics {
        grid-template-columns: repeat(2, 1fr)
      }

      .reference-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px
      }

      .reference-tile span {
        font-size: 9px;
        padding: 7px
      }

      .trustitem b {
        font-size: 14px
      }

      .footer-grid {
        grid-template-columns: 1fr
      }

      .footer-grid>div:first-child {
        grid-column: auto
      }

      .footer-bottom {
        flex-direction: column
      }

      .section-head {
        margin-bottom: 30px
      }
    }

    @media(prefers-reduced-motion:reduce) {

      *,
      *:before,
      *:after {
        scroll-behavior: auto !important;
        animation: none !important;
        transition: none !important
      }

      .reveal {
        opacity: 1;
        transform: none
      }
    }

    /* Section-by-section cinematic reveal system */
    section[data-section-motion]>.wrap,
    section[data-section-motion]>.wrap.hero-grid {
      opacity: 0;
      transition: opacity .9s ease, transform 1s cubic-bezier(.16, 1, .3, 1), clip-path 1.1s cubic-bezier(.16, 1, .3, 1);
      will-change: opacity, transform, clip-path;
    }

    section[data-section-motion="rise"]>.wrap {
      transform: translate3d(0, 58px, 0)
    }

    section[data-section-motion="slide-left"]>.wrap {
      transform: translate3d(-76px, 18px, 0)
    }

    section[data-section-motion="slide-right"]>.wrap {
      transform: translate3d(76px, 18px, 0)
    }

    section[data-section-motion="zoom"]>.wrap {
      transform: scale(.92) translateY(28px)
    }

    section[data-section-motion="clip"]>.wrap {
      transform: translateY(34px);
      clip-path: inset(0 0 16% 0 round 24px)
    }

    section[data-section-motion].section-visible>.wrap {
      opacity: 1;
      transform: none;
      clip-path: inset(0 0 0 0 round 0)
    }

    /* Headings and content groups cascade after their section enters view */
    section[data-section-motion] .section-head,
    section[data-section-motion] .metrics,
    section[data-section-motion] .feature-grid,
    section[data-section-motion] .apps-grid,
    section[data-section-motion] .pillar-grid,
    section[data-section-motion] .data-block,
    section[data-section-motion] .slide-list,
    section[data-section-motion] .reference-grid {
      transition: opacity .75s ease .18s, transform .85s cubic-bezier(.16, 1, .3, 1) .18s;
    }

    section[data-section-motion]:not(.section-visible) .section-head {
      opacity: 0;
      transform: translateY(22px)
    }

    section[data-section-motion]:not(.section-visible) .metrics,
    section[data-section-motion]:not(.section-visible) .feature-grid,
    section[data-section-motion]:not(.section-visible) .apps-grid,
    section[data-section-motion]:not(.section-visible) .pillar-grid,
    section[data-section-motion]:not(.section-visible) .data-block,
    section[data-section-motion]:not(.section-visible) .slide-list,
    section[data-section-motion]:not(.section-visible) .reference-grid {
      opacity: 0;
      transform: translateY(30px)
    }

    section[data-section-motion].section-visible .section-head,
    section[data-section-motion].section-visible .metrics,
    section[data-section-motion].section-visible .feature-grid,
    section[data-section-motion].section-visible .apps-grid,
    section[data-section-motion].section-visible .pillar-grid,
    section[data-section-motion].section-visible .data-block,
    section[data-section-motion].section-visible .slide-list,
    section[data-section-motion].section-visible .reference-grid {
      opacity: 1;
      transform: none
    }

    section[data-section-motion] .feature,
    section[data-section-motion] .app-card,
    section[data-section-motion] .pillar,
    section[data-section-motion] .slide-card,
    section[data-section-motion] .reference-tile,
    section[data-section-motion] .metric {
      transition-delay: calc(.12s + var(--stagger, 0) * 85ms);
    }

    section[data-section-motion] .feature:hover,
    section[data-section-motion] .app-card:hover,
    section[data-section-motion] .pillar:hover,
    section[data-section-motion] .reference-tile:hover {
      transition-delay: 0ms
    }

    .hero .hero-grid {
      animation: heroEntrance 1.15s cubic-bezier(.16, 1, .3, 1) both
    }

    .hero .hero-visual {
      animation: heroFloat 7s ease-in-out 1.1s infinite
    }

    @keyframes heroEntrance {
      from {
        opacity: 0;
        transform: translateY(34px) scale(.985)
      }

      to {
        opacity: 1;
        transform: none
      }
    }

    @keyframes heroFloat {

      0%,
      100% {
        transform: translateY(0)
      }

      50% {
        transform: translateY(-12px)
      }
    }

    @media(prefers-reduced-motion:reduce) {

      section[data-section-motion]>.wrap,
      section[data-section-motion] .section-head,
      section[data-section-motion] .metrics,
      section[data-section-motion] .feature-grid,
      section[data-section-motion] .apps-grid,
      section[data-section-motion] .pillar-grid,
      section[data-section-motion] .data-block,
      section[data-section-motion] .slide-list,
      section[data-section-motion] .reference-grid {
        opacity: 1 !important;
        transform: none !important;
        clip-path: none !important;
        transition: none !important
      }

      .hero .hero-grid,
      .hero .hero-visual {
        animation: none !important
      }
    }


    /* Editable, text-first marketing strategy sections — no photographed notes/slides */
    .note-section .section-head {
      max-width: 760px
    }

    .note-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 18px
    }

    .note-card,
    .audience-card,
    .digital-card {
      background: #fff;
      border: 1px solid #e8edf6;
      border-radius: 22px;
      padding: 25px;
      box-shadow: 0 12px 34px rgba(16, 25, 75, .055);
      transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease
    }

    .note-card:hover,
    .audience-card:hover,
    .digital-card:hover,
    .trigger-grid article:hover {
      transform: translateY(-7px);
      box-shadow: 0 22px 48px rgba(16, 25, 75, .11);
      border-color: rgba(7, 156, 219, .35)
    }

    .note-index {
      font-size: 11px;
      font-weight: 900;
      color: #0788ED;
      letter-spacing: 1px
    }

    .note-icon {
      width: 48px;
      height: 48px;
      display: grid;
      place-items: center;
      border-radius: 15px;
      margin: 22px 0 18px;
      background: linear-gradient(135deg, #082C78, #0788ED);
      color: #fff;
      font-size: 23px
    }

    .note-card h3,
    .audience-card h3,
    .digital-card h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #151b50;
      font-size: 17px;
      margin: 0 0 9px
    }

    .note-card p,
    .audience-card li,
    .digital-card p {
      font-size: 13px;
      line-height: 1.8;
      color: #65708b;
      margin: 0
    }

    .strategy-layout {
      display: grid;
      grid-template-columns: .9fr 1.1fr;
      gap: 25px;
      align-items: stretch
    }

    .strategy-feature {
      border-radius: 26px;
      padding: 34px;
      background: linear-gradient(135deg, #071A45, #3920A5 62%, #0788ED);
      color: #fff;
      box-shadow: 0 22px 55px rgba(17, 20, 81, .18)
    }

    .strategy-feature h3 {
      font: 700 24px 'Plus Jakarta Sans', sans-serif;
      margin: 14px 0 8px
    }

    .strategy-feature p {
      font-size: 13px;
      line-height: 1.8;
      color: #dbe9ff;
      margin: 0
    }

    .strategy-label,
    .digital-kicker {
      font-size: 10px;
      font-weight: 900;
      letter-spacing: 1.6px;
      text-transform: uppercase;
      color: #0788ED
    }

    .strategy-feature .strategy-label {
      color: #9de6ff
    }

    .strategy-divider {
      height: 1px;
      background: rgba(255, 255, 255, .2);
      margin: 25px 0
    }

    .strategy-list {
      display: grid;
      gap: 10px
    }

    .strategy-row {
      display: flex;
      gap: 17px;
      align-items: flex-start;
      padding: 17px 19px;
      border: 1px solid #e8edf6;
      border-radius: 17px;
      background: #fff;
      transition: transform .3s ease, box-shadow .3s ease
    }

    .strategy-row:hover {
      transform: translateX(6px);
      box-shadow: 0 12px 26px rgba(16, 25, 75, .07)
    }

    .strategy-row>span {
      font-size: 12px;
      font-weight: 900;
      color: #0788ED;
      padding-top: 2px
    }

    .strategy-row h3 {
      font-size: 14px;
      color: #151b50;
      margin: 0 0 4px
    }

    .strategy-row p {
      font-size: 12px;
      color: #65708b;
      line-height: 1.65;
      margin: 0
    }

    .dark .section-head.light h2,
    .dark .section-head.light p {
      color: #fff
    }

    .dark .section-head.light p {
      opacity: .76
    }

    .dark .eyebrow {
      color: #8fe5ff
    }

    .network-hub {
      width: min(390px, 100%);
      margin: 0 auto 32px;
      text-align: center;
      padding: 23px 20px;
      border: 1px solid rgba(255, 255, 255, .23);
      border-radius: 24px;
      background: rgba(255, 255, 255, .1);
      backdrop-filter: blur(10px);
      box-shadow: 0 15px 45px rgba(0, 0, 0, .12)
    }

    .network-hub span,
    .network-hub small {
      display: block;
      color: #c8dcff;
      font-size: 10px;
      letter-spacing: 1.3px;
      text-transform: uppercase
    }

    .network-hub strong {
      display: block;
      color: #fff;
      font: 800 24px 'Plus Jakarta Sans', sans-serif;
      margin: 7px 0
    }

    .network-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 15px
    }

    .network-grid article {
      padding: 22px;
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, .18);
      background: rgba(255, 255, 255, .08);
      transition: transform .35s ease, background .35s ease
    }

    .network-grid article:hover {
      transform: translateY(-7px);
      background: rgba(255, 255, 255, .14)
    }

    .network-grid b {
      color: #8fe5ff;
      font-size: 11px
    }

    .network-grid h3 {
      color: #fff;
      font-size: 15px;
      margin: 13px 0 8px
    }

    .network-grid p {
      color: #d5e1ff;
      font-size: 12px;
      line-height: 1.7;
      margin: 0
    }

    .audience-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 16px
    }

    .audience-card {
      padding: 23px
    }

    .audience-card ul {
      list-style: none;
      padding: 0;
      margin: 15px 0 0;
      display: grid;
      gap: 10px
    }

    .audience-card li {
      position: relative;
      padding-left: 17px
    }

    .audience-card li:before {
      content: "";
      position: absolute;
      left: 0;
      top: 9px;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #0788ED
    }

    .community-band {
      margin-top: 24px;
      border-radius: 24px;
      background: #fff;
      border: 1px solid #e8edf6;
      padding: 25px;
      display: grid;
      grid-template-columns: .75fr 1.25fr;
      gap: 20px;
      align-items: center
    }

    .community-band h3 {
      font: 700 20px 'Plus Jakarta Sans', sans-serif;
      color: #151b50;
      margin: 8px 0
    }

    .community-band p {
      font-size: 12px;
      color: #65708b;
      line-height: 1.7;
      margin: 0
    }

    .community-tags,
    .sector-tags,
    .tag-list {
      display: flex;
      flex-wrap: wrap;
      gap: 9px
    }

    .community-tags span,
    .sector-tags span,
    .tag-list span {
      border: 1px solid #e1e9f5;
      background: #f5f8fd;
      color: #344263;
      border-radius: 999px;
      padding: 8px 12px;
      font-size: 11px;
      font-weight: 800
    }

    .digital-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 17px
    }

    .digital-card {
      padding: 26px
    }

    .digital-card h3 {
      font-size: 18px;
      margin: 10px 0 18px
    }

    .digital-card .subhead {
      font-size: 14px;
      margin: 22px 0 12px
    }

    .offer-list {
      display: grid;
      gap: 13px
    }

    .offer-list div {
      display: flex;
      gap: 12px;
      align-items: center;
      border-top: 1px solid #edf0f6;
      padding-top: 13px
    }

    .offer-list b {
      color: #0788ED;
      font-size: 12px
    }

    .offer-list span {
      font-size: 13px;
      font-weight: 800;
      color: #344263
    }

    .sector-panel {
      margin-top: 22px;
      padding: 28px;
      border-radius: 24px;
      background: linear-gradient(120deg, #F5F3FF, #EEFCFF);
      border: 1px solid #E7E4F5;
      display: grid;
      grid-template-columns: .7fr 1.3fr;
      gap: 25px;
      align-items: center
    }

    .sector-panel h3 {
      font: 700 20px 'Plus Jakarta Sans', sans-serif;
      color: #151b50;
      margin: 8px 0
    }

    .sector-panel p {
      font-size: 12px;
      color: #65708b;
      line-height: 1.7;
      margin: 0
    }

    .trigger-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 15px
    }

    .trigger-grid article {
      padding: 23px;
      border: 1px solid #e8edf6;
      border-radius: 20px;
      background: #fff;
      transition: transform .3s ease, box-shadow .3s ease
    }

    .trigger-grid article>span {
      color: #0788ED;
      font-size: 11px;
      font-weight: 900
    }

    .trigger-grid h3 {
      font-size: 15px;
      color: #151b50;
      margin: 13px 0 7px
    }

    .trigger-grid p {
      font-size: 12px;
      color: #65708b;
      line-height: 1.7;
      margin: 0
    }

    .closing-note {
      margin-top: 22px;
      padding: 26px;
      border-radius: 22px;
      background: linear-gradient(115deg, #071A45, #3920A5 65%, #0788ED);
      color: #fff
    }

    .closing-note strong {
      font: 800 17px 'Plus Jakarta Sans', sans-serif
    }

    .closing-note p {
      font-size: 13px;
      line-height: 1.8;
      color: #e0edff;
      margin: 10px 0 0
    }

    @media(max-width:980px) {

      .note-grid,
      .network-grid,
      .audience-grid,
      .trigger-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .digital-grid {
        grid-template-columns: 1fr 1fr
      }

      .digital-card:last-child {
        grid-column: 1/-1
      }
    }

    @media(max-width:700px) {

      .strategy-layout,
      .community-band,
      .sector-panel {
        grid-template-columns: 1fr
      }

      .note-grid,
      .network-grid,
      .audience-grid,
      .digital-grid,
      .trigger-grid {
        grid-template-columns: 1fr
      }

      .digital-card:last-child {
        grid-column: auto
      }

      .note-card,
      .audience-card,
      .digital-card {
        padding: 21px
      }

      .network-hub strong {
        font-size: 20px
      }

      .community-band,
      .sector-panel {
        padding: 21px
      }
    }


    .hero-dashboard {
      position: relative;
      width: min(100%, 510px);
      margin: auto;
      padding: 25px;
      border: 1px solid rgba(255, 255, 255, .8);
      border-radius: 28px;
      background: rgba(255, 255, 255, .88);
      box-shadow: 0 35px 90px rgba(17, 20, 81, .17);
      backdrop-filter: blur(14px);
      transform: rotate(1.5deg);
      animation: heroDashboardIn 1s cubic-bezier(.16, 1, .3, 1) both
    }

    .hero-dashboard-top {
      display: flex;
      align-items: center;
      gap: 9px;
      color: #65708b;
      font-size: 9px;
      font-weight: 900;
      letter-spacing: 1.3px
    }

    .hero-dashboard-top b {
      margin-left: auto;
      padding: 7px 10px;
      background: #edf8ff;
      border-radius: 8px;
      color: #0788ED
    }

    .hero-live-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #0788ED;
      box-shadow: 0 0 0 5px rgba(7, 156, 219, .1)
    }

    .hero-dashboard-title {
      font: 800 clamp(19px, 2.5vw, 26px) 'Plus Jakarta Sans', sans-serif;
      color: #151b50;
      margin: 23px 0 18px
    }

    .hero-dashboard-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px
    }

    .hero-dashboard-grid div {
      padding: 16px;
      border: 1px solid #e8edf6;
      border-radius: 15px;
      background: #fff
    }

    .hero-dashboard-grid small {
      display: block;
      color: #0788ED;
      font-size: 9px;
      font-weight: 900
    }

    .hero-dashboard-grid strong {
      display: block;
      color: #151b50;
      font: 800 18px 'Plus Jakarta Sans', sans-serif;
      margin: 7px 0 3px
    }

    .hero-dashboard-grid span {
      color: #71809d;
      font-size: 10px
    }

    .hero-dashboard-bottom {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 6px;
      margin-top: 18px;
      padding-top: 15px;
      border-top: 1px solid #e8edf6;
      color: #65708b;
      font-size: 8px;
      font-weight: 900;
      letter-spacing: .5px
    }

    .hero-dashboard-bottom i {
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background: #0788ED
    }

    @keyframes heroDashboardIn {
      from {
        opacity: 0;
        transform: translateY(25px) rotate(4deg) scale(.96)
      }

      to {
        opacity: 1;
        transform: translateY(0) rotate(1.5deg) scale(1)
      }
    }

    @media(max-width:620px) {
      .hero-dashboard {
        padding: 18px;
        border-radius: 21px
      }

      .hero-dashboard-grid div {
        padding: 12px
      }

      .hero-dashboard-bottom {
        font-size: 7px
      }
    }


    .contact-details {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 13px;
      margin: 25px 0 28px;
    }

    .contact-detail {
      display: flex;
      align-items: flex-start;
      gap: 13px;
      padding: 16px 18px;
      border: 1px solid rgba(255, 255, 255, .18);
      border-radius: 17px;
      background: rgba(255, 255, 255, .09);
      backdrop-filter: blur(10px)
    }

    .contact-symbol {
      flex: 0 0 36px;
      height: 36px;
      display: grid;
      place-items: center;
      border-radius: 11px;
      background: rgba(7, 156, 219, .2);
      color: #9be8ff;
      font-size: 18px
    }

    .contact-detail small {
      display: block;
      color: #a9d9f2;
      font-size: 9px;
      font-weight: 900;
      letter-spacing: 1.3px;
      margin-bottom: 5px
    }

    .contact-detail a,
    .contact-detail p {
      color: #fff;
      text-decoration: none;
      font-size: 13px;
      line-height: 1.7;
      margin: 0;
      overflow-wrap: anywhere
    }

    .contact-detail a:hover {
      color: #9be8ff
    }

    .contact-detail strong {
      font-weight: 800
    }

    .footer-contact {
      min-width: 0
    }

    .footer-contact h4 {
      color: #fff
    }

    .footer-contact a {
      display: block;
      color: inherit;
      text-decoration: none;
      font-size: 12px;
      margin: 0 0 9px;
      overflow-wrap: anywhere
    }

    .footer-contact p {
      font-size: 11px;
      line-height: 1.8;
      opacity: .75;
      max-width: 260px
    }

    .network-grid article>b {
      display: none
    }

    @media(max-width:700px) {
      .contact-details {
        grid-template-columns: 1fr
      }

      .contact-detail {
        padding: 14px
      }

      .footer-contact p {
        max-width: none
      }
    }



    /* Premium alignment, rhythm and interaction refinement */
    :root {
      --gradient: linear-gradient(112deg, #071A45 0%, #1746A2 54%, #0788ED 100%);
      --shadow-soft: 0 14px 38px rgba(17, 30, 82, .075);
      --shadow-hover: 0 25px 58px rgba(17, 30, 82, .14);
    }

    body {
      font-size: 15px;
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility
    }

    .wrap {
      max-width: 1240px
    }

    p {
      max-width: 72ch
    }

    header {
      box-shadow: 0 8px 28px rgba(16, 28, 75, .035)
    }

    .nav {
      min-height: 92px
    }

    .brand {
      display: flex;
      align-items: center;
      min-width: 0
    }

    .brand img {
      width: clamp(205px, 22vw, 270px);
      height: 72px;
      object-fit: contain;
      object-position: left center
    }

    .navlinks {
      gap: clamp(13px, 1.7vw, 25px)
    }

    .navlinks a:not(.navbtn) {
      position: relative;
      padding: 9px 0
    }

    .navlinks a:not(.navbtn):after {
      content: "";
      position: absolute;
      left: 0;
      right: 100%;
      bottom: 2px;
      height: 2px;
      border-radius: 3px;
      background: var(--gradient);
      transition: right .28s ease
    }

    .navlinks a:not(.navbtn):hover:after {
      right: 0
    }

    .hero {
      padding: clamp(68px, 7vw, 100px) 0
    }

    .hero-grid {
      gap: clamp(32px, 5vw, 68px)
    }

    .hero-copy {
      max-width: 650px
    }

    .hero h1 {
      max-width: 650px;
      letter-spacing: -.055em
    }

    .hero p {
      max-width: 560px;
      line-height: 1.9
    }

    .hero-visual {
      max-width: 590px;
      width: 100%;
      justify-self: end
    }

    .section {
      position: relative;
      isolation: isolate;
      padding: clamp(70px, 7.5vw, 100px) 0
    }

    .section-head {
      max-width: 790px;
      margin-bottom: clamp(30px, 4vw, 48px)
    }

    .section-head h2 {
      max-width: 760px;
      margin-left: auto;
      margin-right: auto;
      letter-spacing: -.045em
    }

    .section-head p {
      max-width: 650px;
      margin: 0 auto;
      line-height: 1.85
    }

    .note-grid,
    .audience-grid,
    .digital-grid,
    .network-grid,
    .feature-grid,
    .pillar-grid,
    .apps-grid,
    .metrics,
    .reference-grid {
      align-items: stretch
    }

    .note-card,
    .audience-card,
    .digital-card,
    .pillar,
    .feature,
    .app-card,
    .slide-card,
    .data-panel,
    .metric,
    .reference-tile {
      min-width: 0
    }

    .note-card p,
    .audience-card p,
    .digital-card p,
    .pillar p,
    .app-card p,
    .feature small {
      line-height: 1.85
    }

    .note-card h3,
    .audience-card h3,
    .digital-card h3,
    .app-card h3,
    .pillar h3 {
      line-height: 1.3
    }

    .network-grid article,
    .trigger-grid article {
      min-width: 0
    }

    .network-grid article {
      padding: clamp(20px, 2.5vw, 30px);
      border-radius: 21px;
      transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease
    }

    .network-grid article:hover {
      transform: translateY(-7px);
      box-shadow: 0 22px 48px rgba(4, 10, 52, .2)
    }

    .slide-card {
      padding: clamp(18px, 2.5vw, 30px);
      gap: clamp(22px, 3.5vw, 42px)
    }

    .slide-copy {
      min-width: 0
    }

    .slide-text {
      gap: 11px
    }

    .content-line {
      font-size: 13px;
      line-height: 1.8;
      overflow-wrap: anywhere
    }

    .slide-preview {
      min-width: 0
    }

    .slide-preview img {
      width: 100%;
      height: auto;
      aspect-ratio: 16/9;
      object-fit: contain
    }

    .data-panel {
      height: 100%;
      box-shadow: var(--shadow-soft)
    }

    .chip {
      transition: transform .22s ease, background .22s ease
    }

    .chip:hover {
      transform: translateY(-2px);
      background: #e1f3ff
    }

    .reference-tile {
      box-shadow: 0 8px 22px rgba(16, 25, 75, .045);
      transition: transform .3s ease, box-shadow .3s ease
    }

    .reference-tile:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover)
    }

    .cta {
      padding: clamp(54px, 6vw, 76px) 0
    }

    .cta-inner {
      align-items: center
    }

    .contact-details {
      width: 100%;
      gap: 14px
    }

    .contact-detail {
      min-height: 82px;
      align-items: center;
      transition: transform .25s ease, background .25s ease, border-color .25s ease
    }

    .contact-detail:hover {
      transform: translateY(-3px);
      background: rgba(255, 255, 255, .14);
      border-color: rgba(255, 255, 255, .34)
    }

    .contact-detail a {
      font-weight: 750
    }

    .address-detail {
      grid-column: 1/-1
    }

    .footer-grid {
      grid-template-columns: 1.35fr .8fr 1fr 1fr;
      align-items: start;
      gap: clamp(22px, 3vw, 42px)
    }

    .footer-contact p {
      max-width: 310px
    }

    footer a {
      transition: color .2s ease
    }

    footer a:hover {
      color: #fff
    }

    .btn,
    .navbtn {
      position: relative;
      overflow: hidden
    }

    .btn:before,
    .navbtn:before {
      content: "";
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 20%, rgba(255, 255, 255, .22) 50%, transparent 80%);
      transition: transform .65s ease
    }

    .btn:hover:before,
    .navbtn:hover:before {
      transform: translateX(120%)
    }

    .section:before {
      pointer-events: none
    }

    .section.soft:before {
      content: "";
      position: absolute;
      z-index: -1;
      width: 360px;
      height: 360px;
      right: -210px;
      top: 8%;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(7, 156, 219, .055), transparent 70%)
    }

    .reveal {
      will-change: opacity, transform
    }

    @media(min-width:761px) {
      .slide-card {
        min-height: 310px
      }

      .slide-card:nth-child(even) {
        grid-template-columns: 1.08fr .92fr
      }

      .slide-card:nth-child(even) .slide-copy {
        padding-left: 8px
      }
    }

    @media(max-width:980px) {
      .footer-grid {
        grid-template-columns: 1fr 1fr
      }

      .footer-grid>div:first-child {
        grid-column: 1/-1
      }
    }

    @media(max-width:760px) {
      .nav {
        min-height: 76px
      }

      .brand img {
        width: clamp(165px, 48vw, 205px);
        height: 55px
      }

      .hero {
        padding: 56px 0 64px
      }

      .hero-grid {
        gap: 28px
      }

      .hero-copy {
        margin-inline: auto
      }

      .hero-visual {
        justify-self: center
      }

      .section {
        padding: 66px 0
      }

      .section-head {
        text-align: center
      }

      .section-head h2 {
        font-size: clamp(28px, 7.5vw, 37px)
      }

      .slide-card {
        gap: 18px
      }

      .contact-details {
        margin: 24px 0
      }

      .address-detail {
        grid-column: auto
      }

      .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 25px
      }
    }

    @media(max-width:480px) {
      .wrap {
        width: calc(100% - 32px)
      }

      .brand img {
        width: 164px;
        height: 50px
      }

      .hero h1 {
        font-size: clamp(35px, 10vw, 46px);
        line-height: 1.1
      }

      .hero p {
        font-size: 14px
      }

      .section {
        padding: 58px 0
      }

      .section-head {
        margin-bottom: 28px
      }

      .note-card,
      .audience-card,
      .digital-card,
      .app-card,
      .pillar {
        padding: 21px;
        border-radius: 18px
      }

      .slide-card {
        padding: 14px;
        border-radius: 18px
      }

      .slide-copy h3 {
        font-size: 22px
      }

      .content-line {
        font-size: 12px
      }

      .contact-detail {
        gap: 11px;
        padding: 13px
      }

      .contact-detail a,
      .contact-detail p {
        font-size: 12px
      }

      .footer-grid {
        grid-template-columns: 1fr
      }

      .footer-grid>div:first-child {
        grid-column: auto
      }
    }

    @media(prefers-reduced-motion:reduce) {

      .btn:before,
      .navbtn:before {
        display: none
      }

      .contact-detail,
      .network-grid article,
      .reference-tile {
        transition: none
      }
    }



    #pageProgress {
      position: fixed;
      z-index: 10001;
      top: 0;
      left: 0;
      width: 0;
      height: 3px;
      background: linear-gradient(90deg, #071A45, #0788ED);
      box-shadow: 0 0 12px rgba(7, 156, 219, .35);
      transition: width .08s linear
    }



    /* Premium card system: consistent spacing, depth, borders and subtle motion */
    :root {
      --card-ink: #071A45;
      --card-muted: #66728d;
      --card-border: #e5ebf5;
      --card-blue: #0788ED;
      --card-glow: rgba(7, 156, 219, .12);
      --card-shadow: 0 12px 32px rgba(17, 30, 82, .065);
      --card-shadow-hover: 0 24px 54px rgba(17, 30, 82, .13);
    }

    .note-grid,
    .audience-grid,
    .digital-grid,
    .network-grid,
    .trigger-grid,
    .apps-grid,
    .pillar-grid,
    .feature-grid,
    .metrics,
    .data-block {
      align-items: stretch;
    }

    .note-card,
    .audience-card,
    .digital-card,
    .app-card,
    .pillar,
    .feature,
    .metric,
    .data-panel,
    .network-grid article,
    .trigger-grid article {
      position: relative;
      isolation: isolate;
      overflow: hidden;
      border: 1px solid var(--card-border);
      border-radius: 22px;
      background: linear-gradient(150deg, #fff 0%, #fff 68%, #f7fbff 100%);
      box-shadow: var(--card-shadow);
      transition: transform .38s cubic-bezier(.2, .75, .25, 1),
        box-shadow .38s ease, border-color .38s ease,
        background .38s ease;
    }

    .note-card:before,
    .audience-card:before,
    .digital-card:before,
    .app-card:before,
    .pillar:before,
    .feature:before,
    .metric:before,
    .data-panel:before,
    .network-grid article:before,
    .trigger-grid article:before {
      content: "";
      position: absolute;
      z-index: -1;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #071A45 0%, #1746A2 55%, #0788ED 100%);
      opacity: .82;
      transform: scaleX(.38);
      transform-origin: left;
      transition: transform .38s ease, opacity .38s ease;
    }

    .note-card:after,
    .audience-card:after,
    .digital-card:after,
    .app-card:after,
    .pillar:after,
    .network-grid article:after,
    .trigger-grid article:after {
      content: "";
      position: absolute;
      z-index: -1;
      width: 170px;
      height: 170px;
      right: -105px;
      bottom: -112px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(7, 156, 219, .09), transparent 70%);
      opacity: 0;
      transition: opacity .4s ease, transform .5s ease;
    }

    .note-card:hover,
    .audience-card:hover,
    .digital-card:hover,
    .app-card:hover,
    .pillar:hover,
    .feature:hover,
    .metric:hover,
    .data-panel:hover,
    .network-grid article:hover,
    .trigger-grid article:hover {
      transform: translateY(-8px);
      box-shadow: var(--card-shadow-hover);
      border-color: rgba(7, 156, 219, .3);
      background: linear-gradient(150deg, #fff 0%, #fff 58%, #f3faff 100%);
    }

    .note-card:hover:before,
    .audience-card:hover:before,
    .digital-card:hover:before,
    .app-card:hover:before,
    .pillar:hover:before,
    .feature:hover:before,
    .metric:hover:before,
    .data-panel:hover:before,
    .network-grid article:hover:before,
    .trigger-grid article:hover:before {
      transform: scaleX(1);
      opacity: 1
    }

    .note-card:hover:after,
    .audience-card:hover:after,
    .digital-card:hover:after,
    .app-card:hover:after,
    .pillar:hover:after,
    .network-grid article:hover:after,
    .trigger-grid article:hover:after {
      opacity: 1;
      transform: scale(1.2)
    }

    .note-card,
    .audience-card,
    .digital-card,
    .app-card,
    .pillar {
      height: 100%
    }

    .note-card {
      padding: clamp(22px, 2.4vw, 30px);
      display: flex;
      flex-direction: column
    }

    .note-card .note-icon {
      box-shadow: 0 8px 18px rgba(17, 42, 110, .18);
      transition: transform .35s ease, box-shadow .35s ease
    }

    .note-card:hover .note-icon {
      transform: translateY(-3px) rotate(-5deg);
      box-shadow: 0 12px 25px rgba(17, 42, 110, .23)
    }

    .note-card h3,
    .audience-card h3,
    .digital-card h3,
    .app-card h3,
    .pillar h3,
    .network-grid article h3,
    .trigger-grid article h3 {
      color: var(--card-ink);
      letter-spacing: -.035em;
    }

    .note-card p,
    .audience-card li,
    .app-card li,
    .pillar p,
    .network-grid article p,
    .trigger-grid article p {
      color: var(--card-muted);
    }

    .audience-card,
    .digital-card,
    .app-card,
    .pillar {
      padding: clamp(22px, 2.5vw, 30px)
    }

    .audience-card ul,
    .app-card ul {
      padding-left: 19px
    }

    .audience-card li,
    .app-card li {
      line-height: 1.8
    }

    .audience-card li::marker,
    .app-card li::marker {
      color: var(--card-blue)
    }

    .digital-card .digital-kicker {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      border: 1px solid #dceefa;
      background: #f0f8ff;
      color: #126b9f;
      border-radius: 99px;
      padding: 7px 11px;
      font-size: 10px;
      font-weight: 900;
      letter-spacing: .9px;
    }

    .digital-card .tag-list span {
      border: 1px solid #e2edf8;
      background: linear-gradient(180deg, #fff, #f5faff);
      border-radius: 999px;
      padding: 8px 12px;
      color: #29466f;
      font-weight: 750;
      transition: transform .22s ease, border-color .22s ease, background .22s ease;
    }

    .digital-card .tag-list span:hover {
      transform: translateY(-2px);
      border-color: #9ed8f2;
      background: #edf8ff
    }

    .app-card {
      display: flex;
      flex-direction: column
    }

    .app-card h3 {
      font-size: clamp(18px, 2vw, 21px);
      margin: 0 0 15px;
      min-height: 2.6em
    }

    .app-card ul {
      margin-top: 0
    }

    .pillar {
      display: flex;
      flex-direction: column;
      align-items: flex-start
    }

    .pillar .num {
      border: 1px solid #d8edfa;
      background: linear-gradient(135deg, #eef8ff, #F3EFFF);
      box-shadow: inset 0 1px 0 #fff, 0 6px 14px rgba(7, 156, 219, .08);
    }

    .feature {
      box-shadow: 0 7px 20px rgba(17, 30, 82, .045);
      padding: 18px 19px;
      align-items: center;
    }

    .feature-icon {
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8), 0 7px 16px rgba(7, 90, 160, .1);
      flex-shrink: 0;
    }

    .feature>div:last-child {
      min-width: 0
    }

    .feature b {
      line-height: 1.4
    }

    .feature small {
      display: block;
      margin-top: 3px
    }

    .metric {
      padding: clamp(20px, 2.4vw, 28px);
      backdrop-filter: blur(12px)
    }

    .metric strong {
      letter-spacing: -.045em
    }

    .data-panel {
      padding: clamp(22px, 2.6vw, 30px)
    }

    .network-grid article,
    .trigger-grid article {
      padding: clamp(22px, 2.5vw, 30px)
    }

    .network-grid article h3,
    .trigger-grid article h3 {
      line-height: 1.3
    }

    .network-grid article p,
    .trigger-grid article p {
      line-height: 1.8
    }

    .trigger-grid article>span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      height: 36px;
      padding: 0 10px;
      border-radius: 12px;
      background: #F1F4FF;
      color: #087bb5;
      font-size: 11px;
      font-weight: 900;
      margin-bottom: 17px;
    }

    @media(min-width:761px) {

      .apps-grid,
      .note-grid,
      .audience-grid,
      .digital-grid,
      .pillar-grid {
        grid-auto-rows: 1fr
      }
    }

    @media(max-width:760px) {

      .note-card,
      .audience-card,
      .digital-card,
      .app-card,
      .pillar,
      .network-grid article,
      .trigger-grid article {
        border-radius: 19px
      }

      .note-card:hover,
      .audience-card:hover,
      .digital-card:hover,
      .app-card:hover,
      .pillar:hover,
      .feature:hover,
      .metric:hover,
      .data-panel:hover,
      .network-grid article:hover,
      .trigger-grid article:hover {
        transform: translateY(-3px)
      }
    }

    @media(prefers-reduced-motion:reduce) {

      .note-card,
      .audience-card,
      .digital-card,
      .app-card,
      .pillar,
      .feature,
      .metric,
      .data-panel,
      .network-grid article,
      .trigger-grid article,
      .note-card:before,
      .audience-card:before,
      .digital-card:before,
      .app-card:before,
      .pillar:before,
      .feature:before,
      .metric:before,
      .data-panel:before,
      .network-grid article:before,
      .trigger-grid article:before {
        transition: none
      }
    }


    /* =========================================================
   MOBILE + TABLET RESPONSIVE PATCH
   ========================================================= */
    html,
    body {
      width: 100%;
      max-width: 100%;
      overflow-x: clip
    }

    body {
      min-width: 320px
    }

    img,
    svg,
    video,
    canvas {
      max-width: 100%;
      height: auto
    }

    .wrap {
      width: min(1240px, calc(100% - 48px));
      margin-inline: auto
    }

    main,
    section,
    header,
    footer,
    .section,
    .cta {
      min-width: 0
    }

    section .wrap,
    .nav,
    .hero-grid,
    .hero-copy,
    .hero-visual,
    .slide-card,
    .slide-copy,
    .slide-preview,
    .data-block,
    .footer-grid,
    .cta-inner {
      min-width: 0
    }

    h1,
    h2,
    h3,
    h4,
    p,
    li,
    a,
    span,
    strong,
    small {
      overflow-wrap: break-word
    }

    .grid,
    .pillar-grid,
    .feature-grid,
    .apps-grid,
    .metrics,
    .note-grid,
    .audience-grid,
    .digital-grid,
    .network-grid,
    .trigger-grid,
    .reference-grid,
    .trustrow,
    .footer-grid,
    .data-block,
    .strategy-layout,
    .community-band,
    .sector-panel,
    .contact-details {
      min-width: 0
    }

    .feature,
    .app-card,
    .pillar,
    .metric,
    .note-card,
    .audience-card,
    .digital-card,
    .data-panel,
    .slide-card,
    .network-grid article,
    .trigger-grid article,
    .reference-tile {
      min-width: 0;
      max-width: 100%
    }

    .feature>div:last-child {
      min-width: 0
    }

    .content-line {
      overflow-wrap: anywhere;
      white-space: normal
    }

    .slide-preview img {
      display: block;
      width: 100%;
      height: auto;
      max-width: 100%;
      object-fit: contain
    }

    .hero-visual,
    .hero-dashboard {
      max-width: 100%
    }

    .hero-dashboard-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr))
    }

    .contact-details {
      width: min(1240px, calc(100% - 48px));
      margin: 0 auto 30px
    }

    .contact-detail {
      min-width: 0
    }

    .contact-detail>div {
      min-width: 0
    }

    .footer-grid>div {
      min-width: 0
    }

    .footer-grid a {
      overflow-wrap: anywhere
    }

    .menu {
      flex: 0 0 auto;
      cursor: pointer
    }

    .nav {
      position: relative
    }

    .navlinks {
      min-width: 0
    }

    .navlinks a {
      white-space: normal
    }

    .reference-tile img {
      display: block;
      width: 100%;
      height: auto
    }

    .tag-list span,
    .community-tags span,
    .sector-tags span,
    .chip {
      max-width: 100%;
      overflow-wrap: anywhere
    }

    /* Tablets: collapse navigation before links become cramped. */
    @media(max-width:1024px) {
      .nav {
        gap: 14px
      }

      .brand img {
        width: clamp(170px, 24vw, 225px)
      }

      .menu {
        display: inline-flex;
        align-items: center;
        justify-content: center
      }

      .navlinks {
        display: none;
        position: absolute;
        z-index: 150;
        top: calc(100% + 1px);
        left: 0;
        right: 0;
        padding: 14px 18px 20px;
        background: rgba(255, 255, 255, .98);
        border: 1px solid #e8edf6;
        border-top: 0;
        border-radius: 0 0 18px 18px;
        box-shadow: 0 22px 38px rgba(12, 25, 72, .13);
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        max-height: calc(100dvh - 100px);
        overflow-y: auto;
      }

      .navlinks.open {
        display: flex
      }

      .navlinks a:not(.navbtn) {
        padding: 13px 5px;
        border-bottom: 1px solid #edf0f6;
        font-size: 13px
      }

      .navlinks .navbtn {
        margin-top: 14px;
        width: 100%;
        text-align: center
      }

      .hero-grid {
        grid-template-columns: minmax(0, 1fr) minmax(0, .9fr);
        gap: 28px
      }

      .hero h1 {
        font-size: clamp(38px, 5.4vw, 58px)
      }

      .trustrow {
        grid-template-columns: repeat(4, minmax(0, 1fr))
      }

      .pillar-grid,
      .network-grid,
      .audience-grid,
      .trigger-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .apps-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .feature-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .digital-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .digital-card:last-child {
        grid-column: 1/-1
      }

      .reference-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr))
      }

      .footer-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }
    }

    /* Phones and small tablets. */
    @media(max-width:760px) {
      html {
        scroll-padding-top: 78px
      }

      .wrap {
        width: calc(100% - 36px)
      }

      .topline {
        font-size: 10px
      }

      .topline .wrap {
        padding: 8px 0
      }

      .nav {
        min-height: 70px;
        padding: 7px 18px
      }

      .brand img {
        width: clamp(150px, 47vw, 190px);
        height: 51px
      }

      .menu {
        padding: 9px 12px;
        font-size: 21px
      }

      .hero {
        padding: 48px 0 56px
      }

      .hero-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 26px
      }

      .hero-copy {
        width: 100%;
        max-width: 620px
      }

      .hero h1 {
        font-size: clamp(35px, 9.5vw, 51px);
        line-height: 1.1;
        margin: 19px 0 15px
      }

      .hero p {
        font-size: 14px;
        line-height: 1.8
      }

      .hero-actions {
        gap: 10px
      }

      .hero-actions .btn {
        flex: 1 1 180px;
        min-height: 46px;
        padding: 12px 16px
      }

      .hero-visual {
        width: 100%;
        max-width: 560px;
        margin: 4px auto 0;
        transform: none !important
      }

      .hero-dashboard {
        transform: none;
        animation: none;
        padding: 17px
      }

      .hero-dashboard-title {
        margin: 17px 0 14px
      }

      .hero-dashboard-grid {
        gap: 9px
      }

      .hero-dashboard-grid div {
        padding: 12px
      }

      .float-pill {
        left: 8px;
        right: 8px;
        bottom: 8px;
        max-width: calc(100% - 16px);
        font-size: 9px
      }

      .trustrow {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .trustitem {
        padding: 16px 8px;
        min-width: 0
      }

      .trustitem:nth-child(2) {
        border-right: 0
      }

      .trustitem:nth-child(-n+2) {
        border-bottom: 1px solid var(--line)
      }

      .trustitem b {
        font-size: 13px;
        overflow-wrap: anywhere
      }

      .trustitem small {
        font-size: 9px
      }

      .section {
        padding: 58px 0
      }

      .section-head {
        margin: 0 auto 28px;
        padding-inline: 2px
      }

      .section-head h2 {
        font-size: clamp(27px, 7vw, 36px);
        line-height: 1.17
      }

      .section-head p {
        font-size: 13px;
        line-height: 1.75
      }

      .pillar-grid,
      .network-grid,
      .audience-grid,
      .trigger-grid,
      .note-grid,
      .digital-grid,
      .apps-grid,
      .feature-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 13px
      }

      .digital-card:last-child {
        grid-column: auto
      }

      .pillar,
      .note-card,
      .audience-card,
      .digital-card,
      .app-card,
      .network-grid article,
      .trigger-grid article {
        padding: 21px;
        border-radius: 18px
      }

      .pillar h3,
      .note-card h3,
      .audience-card h3,
      .digital-card h3 {
        font-size: 17px
      }

      .app-card h3 {
        min-height: 0;
        font-size: 18px
      }

      .feature {
        padding: 15px;
        gap: 12px
      }

      .feature-icon {
        flex-basis: 35px;
        width: 35px;
        height: 35px
      }

      .metrics {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px
      }

      .metric {
        padding: 16px;
        border-radius: 15px
      }

      .metric strong {
        font-size: clamp(19px, 5vw, 27px)
      }

      .metric span {
        font-size: 10px;
        line-height: 1.5
      }

      .slide-list {
        gap: 15px
      }

      .slide-card {
        grid-template-columns: minmax(0, 1fr);
        gap: 16px;
        padding: 14px;
        border-radius: 18px
      }

      .slide-card:nth-child(even) .slide-copy,
      .slide-card:nth-child(even) .slide-preview {
        order: initial
      }

      .slide-copy h3 {
        font-size: 22px;
        line-height: 1.2
      }

      .content-line {
        font-size: 12px;
        line-height: 1.75
      }

      .slide-preview {
        width: 100%
      }

      .slide-preview img {
        aspect-ratio: 16/9;
        object-fit: contain
      }

      .data-block,
      .strategy-layout,
      .community-band,
      .sector-panel {
        grid-template-columns: minmax(0, 1fr);
        gap: 15px
      }

      .data-panel {
        padding: 20px
      }

      .reference-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px
      }

      .reference-tile span {
        font-size: 10px
      }

      .network-hub {
        margin-bottom: 20px;
        padding: 20px 15px
      }

      .network-hub strong {
        font-size: 20px
      }

      .strategy-feature {
        padding: 24px;
        border-radius: 20px
      }

      .strategy-row {
        padding: 14px;
        gap: 12px
      }

      .community-band,
      .sector-panel {
        padding: 20px
      }

      .cta {
        padding: 45px 0
      }

      .contact-details {
        width: calc(100% - 36px);
        grid-template-columns: minmax(0, 1fr);
        gap: 10px;
        margin: 0 auto 25px
      }

      .contact-detail {
        min-height: 0;
        padding: 14px;
        gap: 11px
      }

      .address-detail {
        grid-column: auto
      }

      .contact-detail a,
      .contact-detail p {
        font-size: 12px
      }

      .cta-inner {
        align-items: flex-start;
        flex-direction: column;
        gap: 18px
      }

      .cta-inner .btn {
        width: 100%
      }

      .footer-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 20px
      }

      .footer-grid>div:first-child {
        grid-column: auto
      }

      .footer-logo {
        width: min(220px, 75vw)
      }

      .footer-bottom {
        flex-direction: column;
        gap: 7px
      }

      .section[data-section-motion]>.wrap {
        transform: translateY(22px)
      }

      .section[data-section-motion].section-visible>.wrap {
        transform: none
      }
    }

    /* Very small phones. */
    @media(max-width:390px) {
      .wrap {
        width: calc(100% - 28px)
      }

      .nav {
        padding-inline: 14px
      }

      .brand img {
        width: 145px;
        height: 47px
      }

      .hero h1 {
        font-size: 34px
      }

      .eyebrow {
        font-size: 9px;
        letter-spacing: 1px;
        padding: 7px 10px
      }

      .hero-actions .btn {
        flex-basis: 100%;
        width: 100%
      }

      .hero-dashboard-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .hero-dashboard-grid strong {
        font-size: 16px
      }

      .trustitem b {
        font-size: 12px
      }

      .metrics {
        grid-template-columns: minmax(0, 1fr)
      }

      .contact-details {
        width: calc(100% - 28px)
      }
    }

    /* Motion is optional: keep content visible and accessible for reduced-motion users. */
    @media(prefers-reduced-motion:reduce) {
      html {
        scroll-behavior: auto
      }

      .hero .hero-grid,
      .hero .hero-visual,
      .hero-dashboard {
        animation: none !important
      }

      section[data-section-motion]>.wrap,
      section[data-section-motion] .section-head,
      section[data-section-motion] .metrics,
      section[data-section-motion] .feature-grid,
      section[data-section-motion] .apps-grid,
      section[data-section-motion] .pillar-grid,
      section[data-section-motion] .data-block,
      section[data-section-motion] .slide-list,
      section[data-section-motion] .reference-grid,
      .reveal {
        opacity: 1 !important;
        transform: none !important;
        clip-path: none !important;
        transition: none !important
      }
    }

    /* Visual story panels: original illustrations in the existing content sections */
    .section-visual-panel {
      display: grid;
      grid-template-columns: .78fr 1.22fr;
      gap: clamp(22px, 4vw, 48px);
      align-items: center;
      margin: 0 0 38px;
      padding: clamp(17px, 2.5vw, 27px);
      border: 1px solid #e4ebf5;
      border-radius: 26px;
      background: linear-gradient(135deg, #fff 0%, #f4f9fe 100%);
      box-shadow: 0 18px 48px rgba(17, 30, 82, .075);
      overflow: hidden
    }

    .section-visual-panel.reverse {
      grid-template-columns: 1.22fr .78fr
    }

    .section-visual-panel.reverse .section-visual-copy {
      order: 2
    }

    .section-visual-panel.reverse .section-visual-image {
      order: 1
    }

    .section-visual-copy {
      padding: 10px 12px;
      min-width: 0
    }

    .visual-kicker {
      display: inline-flex;
      padding: 7px 11px;
      border-radius: 99px;
      background: #eaf5fc;
      color: #126c9f;
      font-size: 10px;
      font-weight: 900;
      letter-spacing: 1.25px
    }

    .section-visual-copy h3 {
      font: 800 clamp(21px, 2.6vw, 30px)/1.2 'Plus Jakarta Sans', sans-serif;
      letter-spacing: -.04em;
      color: #071A45;
      margin: 16px 0 10px
    }

    .section-visual-copy p {
      font-size: 13px;
      line-height: 1.85;
      color: #65718b;
      margin: 0;
      max-width: 45ch
    }

    .section-visual-image {
      min-width: 0;
      border-radius: 18px;
      overflow: hidden;
      background: #edf5fc
    }

    .section-visual-image img {
      display: block;
      width: 100%;
      height: auto;
      aspect-ratio: 760/470;
      object-fit: cover;
      transition: transform .7s cubic-bezier(.2, .7, .2, 1)
    }

    .section-visual-panel:hover .section-visual-image img {
      transform: scale(1.025)
    }

    .whatsapp-symbol {
      background: rgba(25, 190, 96, .16) !important;
      color: #46e28d !important
    }

    .quick-contact {
      position: fixed;
      z-index: 900;
      right: 24px;
      bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px
    }

    .quick-contact a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      min-height: 49px;
      padding: 0 17px;
      border-radius: 999px;
      text-decoration: none;
      font-size: 12px;
      font-weight: 900;
      box-shadow: 0 12px 30px rgba(10, 25, 70, .2);
      transition: transform .25s, box-shadow .25s
    }

    .quick-contact a:hover {
      transform: translateY(-4px);
      box-shadow: 0 17px 36px rgba(10, 25, 70, .25)
    }

    .quick-call {
      background: #fff;
      color: #071A45;
      border: 1px solid #e2eaf5
    }

    .quick-call-icon {
      font-size: 17px
    }

    .quick-whatsapp {
      background: #16a765;
      color: #fff
    }

    @media(max-width:760px) {

      .section-visual-panel,
      .section-visual-panel.reverse {
        grid-template-columns: minmax(0, 1fr);
        gap: 15px;
        margin-bottom: 26px;
        padding: 14px;
        border-radius: 20px
      }

      .section-visual-panel.reverse .section-visual-copy,
      .section-visual-panel.reverse .section-visual-image {
        order: initial
      }

      .section-visual-copy {
        padding: 8px 5px 2px
      }

      .section-visual-copy h3 {
        font-size: 23px;
        margin: 12px 0 7px
      }

      .section-visual-copy p {
        font-size: 12px
      }

      .section-visual-image {
        border-radius: 14px
      }

      .quick-contact {
        left: 12px;
        right: 12px;
        bottom: 12px;
        gap: 9px;
        padding: 7px;
        background: rgba(255, 255, 255, .94);
        border: 1px solid #e5ebf5;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(12, 25, 72, .16);
        backdrop-filter: blur(12px)
      }

      .quick-contact a {
        flex: 1;
        min-height: 45px;
        padding: 0 10px
      }

      body {
        padding-bottom: 78px
      }
    }

    @media(prefers-reduced-motion:reduce) {

      .section-visual-image img,
      .quick-contact a {
        transition: none
      }
    }


    /* PRUDENCE — Healthcare Growth Consultancy visual identity */
    :root {
      --ink: #071A45;
      --ink2: #28236D;
      --blue: #0788ED;
      --cyan: #20D5EF;
      --mist: #f3f8fe;
      --line: #e2eaf5;
      --glass: rgba(255, 255, 255, .78);
      --deep-gradient: linear-gradient(128deg, #071A45 0%, #3920A5 53%, #0788ED 100%);
      --soft-shadow: 0 18px 50px rgba(16, 30, 82, .09);
      --lift-shadow: 0 28px 70px rgba(16, 30, 82, .16);
    }

    body {
      color: #273454;
      background: #fff;
      font-feature-settings: "ss01" on
    }

    ::selection {
      background: #DDFBFF;
      color: #071A45
    }

    .hero {
      position: relative;
      isolation: isolate;
      overflow: hidden;
      background: radial-gradient(ellipse at 82% 18%, rgba(53, 184, 232, .17), transparent 34%), linear-gradient(125deg, #f6f8ff 0%, #fff 48%, #eff9ff 100%)
    }

    .hero:before,
    .hero:after {
      content: "";
      position: absolute;
      z-index: -1;
      border-radius: 50%;
      pointer-events: none
    }

    .hero:before {
      width: 520px;
      height: 520px;
      right: -210px;
      top: -220px;
      border: 1px solid rgba(7, 143, 201, .14);
      box-shadow: 0 0 0 35px rgba(7, 143, 201, .025), 0 0 0 75px rgba(7, 143, 201, .02)
    }

    .hero:after {
      width: 300px;
      height: 300px;
      left: -180px;
      bottom: -170px;
      background: radial-gradient(circle, rgba(7, 143, 201, .12), transparent 70%)
    }

    .hero h1 {
      font-size: clamp(42px, 5.4vw, 70px);
      line-height: 1.045;
      letter-spacing: -.065em;
      color: var(--ink)
    }

    .hero h1 span {
      background: var(--deep-gradient);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent
    }

    .hero .eyebrow,
    .section-head .eyebrow {
      border: 1px solid #d9eaf7;
      background: rgba(255, 255, 255, .76);
      box-shadow: 0 6px 18px rgba(16, 30, 82, .04)
    }

    .hero-dashboard {
      border: 1px solid rgba(255, 255, 255, .95);
      box-shadow: 0 35px 90px rgba(16, 30, 82, .17), 0 4px 14px rgba(16, 30, 82, .05);
      backdrop-filter: blur(18px)
    }

    .float-pill {
      border: 1px solid rgba(255, 255, 255, .8);
      box-shadow: 0 15px 38px rgba(16, 30, 82, .14);
      backdrop-filter: blur(16px)
    }

    .section {
      overflow: hidden
    }

    .section:nth-of-type(even):not(.dark):not(.cta) {
      background-image: radial-gradient(ellipse at 100% 0%, rgba(7, 143, 201, .055), transparent 36%)
    }

    .section-head h2 {
      font-size: clamp(30px, 4vw, 48px);
      line-height: 1.12;
      letter-spacing: -.055em;
      color: var(--ink)
    }

    .section-head p {
      font-size: 15px;
      color: #687590
    }

    .note-card,
    .audience-card,
    .digital-card,
    .app-card,
    .pillar,
    .feature,
    .metric,
    .data-panel,
    .network-grid article,
    .trigger-grid article {
      border-radius: 25px !important;
      border: 1px solid rgba(218, 229, 243, .95) !important;
      box-shadow: 0 10px 30px rgba(16, 30, 82, .055), inset 0 1px 0 #fff !important;
      background: linear-gradient(155deg, #fff 0%, #fff 58%, #f5faff 100%) !important;
    }

    .note-card:hover,
    .audience-card:hover,
    .digital-card:hover,
    .app-card:hover,
    .pillar:hover,
    .feature:hover,
    .metric:hover,
    .data-panel:hover,
    .network-grid article:hover,
    .trigger-grid article:hover {
      transform: translateY(-9px) !important;
      box-shadow: 0 26px 58px rgba(16, 30, 82, .13) !important;
      border-color: rgba(7, 143, 201, .34) !important
    }

    .note-card:before,
    .audience-card:before,
    .digital-card:before,
    .app-card:before,
    .pillar:before,
    .feature:before,
    .metric:before,
    .data-panel:before,
    .network-grid article:before,
    .trigger-grid article:before {
      height: 4px !important;
      background: linear-gradient(90deg, #071A45, #1d4b9a, #20D5EF) !important
    }

    .note-icon,
    .feature-icon {
      background: var(--deep-gradient) !important;
      color: #fff !important;
      border: 0 !important;
      box-shadow: 0 10px 22px rgba(17, 43, 112, .2) !important
    }

    .note-index {
      font-size: 10px;
      letter-spacing: 1.8px
    }

    .note-card h3,
    .audience-card h3,
    .digital-card h3 {
      font-size: 19px;
      letter-spacing: -.035em
    }

    .network-hub {
      background: var(--deep-gradient) !important;
      border: 1px solid rgba(255, 255, 255, .25);
      box-shadow: 0 24px 55px rgba(5, 19, 75, .24)
    }

    .network-grid article {
      background: rgba(255, 255, 255, .97) !important
    }

    .strategy-feature,
    .closing-note {
      background: var(--deep-gradient) !important;
      box-shadow: 0 25px 60px rgba(16, 30, 82, .2)
    }

    .strategy-row {
      border-radius: 18px !important;
      border: 1px solid #e5edf7 !important;
      box-shadow: 0 5px 16px rgba(16, 30, 82, .035)
    }

    .strategy-row:hover {
      transform: translateX(7px);
      border-color: #a9dff4 !important
    }

    .section-visual-panel {
      position: relative;
      border-radius: 30px !important;
      padding: clamp(18px, 3vw, 32px) !important;
      border: 1px solid #e0eaf5 !important;
      box-shadow: 0 20px 55px rgba(16, 30, 82, .09) !important;
      background: linear-gradient(135deg, #fff, #f2f8fe) !important
    }

    .section-visual-panel:after {
      content: "";
      position: absolute;
      right: -90px;
      top: -110px;
      width: 240px;
      height: 240px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(53, 184, 232, .12), transparent 70%);
      pointer-events: none
    }

    .section-visual-image {
      border: 1px solid rgba(255, 255, 255, .9);
      box-shadow: 0 16px 35px rgba(16, 30, 82, .1)
    }

    .section-visual-image img {
      transition: transform .8s cubic-bezier(.2, .7, .2, 1), filter .8s
    }

    .section-visual-panel:hover .section-visual-image img {
      transform: scale(1.04);
      filter: saturate(1.12)
    }

    .contact-detail {
      border-radius: 20px !important;
      box-shadow: 0 12px 30px rgba(3, 12, 55, .12)
    }

    .contact-detail a {
      font-weight: 800
    }

    .btn,
    .navbtn {
      border-radius: 999px !important;
      box-shadow: 0 12px 28px rgba(16, 30, 82, .18) !important;
      transition: transform .3s, box-shadow .3s, filter .3s !important
    }

    .btn:hover,
    .navbtn:hover {
      transform: translateY(-3px);
      filter: brightness(1.06);
      box-shadow: 0 18px 36px rgba(16, 30, 82, .24) !important
    }

    .quick-contact a {
      border-radius: 999px;
      box-shadow: 0 15px 35px rgba(10, 25, 70, .22)
    }

    #pageProgress {
      height: 4px !important;
      background: linear-gradient(90deg, #071A45, #1d4b9a, #20D5EF) !important
    }

    footer {
      background: linear-gradient(135deg, #0b103f, #111d5b 58%, #073e69) !important
    }

    footer .footer-logo {
      filter: drop-shadow(0 5px 12px rgba(0, 0, 0, .12))
    }

    @keyframes softFloat {

      0%,
      100% {
        transform: translateY(0)
      }

      50% {
        transform: translateY(-10px)
      }
    }

    @keyframes glowPulse {

      0%,
      100% {
        box-shadow: 0 0 0 0 rgba(53, 184, 232, .16)
      }

      50% {
        box-shadow: 0 0 0 12px rgba(53, 184, 232, 0)
      }
    }

    .hero-dashboard {
      animation: softFloat 7s ease-in-out infinite
    }

    .hero-live-dot {
      animation: glowPulse 2.8s ease-out infinite
    }

    .section-visual-panel,
    .note-card,
    .audience-card,
    .digital-card,
    .network-grid article,
    .trigger-grid article {
      transform: translateZ(0)
    }

    @media(max-width:760px) {
      .hero {
        background: linear-gradient(150deg, #f5f8ff, #fff 58%, #eef9ff)
      }

      .hero h1 {
        letter-spacing: -.05em
      }

      .section-head h2 {
        letter-spacing: -.045em
      }

      .note-card,
      .audience-card,
      .digital-card,
      .app-card,
      .pillar,
      .network-grid article,
      .trigger-grid article {
        border-radius: 20px !important
      }

      .section-visual-panel {
        box-shadow: 0 12px 30px rgba(16, 30, 82, .07) !important
      }

      .hero-dashboard {
        animation: none
      }

      .quick-contact {
        box-shadow: 0 12px 34px rgba(10, 25, 70, .18)
      }
    }

    @media(prefers-reduced-motion:reduce) {

      .hero-dashboard,
      .hero-live-dot {
        animation: none !important
      }

      .note-card:hover,
      .audience-card:hover,
      .digital-card:hover,
      .app-card:hover,
      .pillar:hover,
      .feature:hover,
      .metric:hover,
      .data-panel:hover,
      .network-grid article:hover,
      .trigger-grid article:hover {
        transform: none !important
      }
    }

    /* Prudence brand palette — sampled to complement the supplied logo */
    :root {
      --navy: #071A45;
      --navy2: #3920A5;
      --blue: #0788ED;
      --cyan: #20D5EF;
      --pink: #8B2BE2;
      --lime: #00B7A8;
      --ink: #101B3D;
      --muted: #68738D;
      --line: #E7EAF4;
      --paper: #F7F8FD;
      --gradient: linear-gradient(112deg, #0788ED 0%, #7028E8 58%, #4B18C9 100%);
      --deep-gradient: linear-gradient(128deg, #071A45 0%, #3920A5 55%, #0788ED 100%);
      --shadow: 0 24px 70px rgba(7, 26, 69, .12);
      --soft-shadow: 0 18px 50px rgba(7, 26, 69, .09);
      --lift-shadow: 0 28px 70px rgba(7, 26, 69, .16);
    }

    .topline {
      background: #071A45;
    }

    .navbtn,
    .btn {
      background: var(--gradient);
    }

    .hero h1 span {
      background: var(--gradient);
      -webkit-background-clip: text;
      background-clip: text;
    }

    .section.dark {
      background: linear-gradient(125deg, #071A45, #3920A5 58%, #0788ED);
    }

    .cta {
      background: radial-gradient(circle at 90% 10%, rgba(32, 213, 239, .22), transparent 30%), var(--deep-gradient);
    }

    footer {
      background: #071A45;
    }

    .eyebrow:before,
    .hero-live-dot {
      background: #00B7A8;
    }

    .contact-symbol {
      background: rgba(0, 183, 168, .18);
      color: #72F1E5;
    }

    .loader-track span {
      background: linear-gradient(90deg, #0788ED, #8B2BE2, #00B7A8);
    }

    ::selection {
      background: #DDFBFF;
      color: #071A45;
    }
  </style>

  <style id="generated-visual-assets">
    .hero-visual {
      overflow: visible;
      background: linear-gradient(145deg, #eafaff, #fff);
      padding: 10px;
      border: 1px solid rgba(36, 170, 220, .24);
      box-shadow: 0 28px 75px rgba(2, 55, 110, .20)
    }

    .hero-visual .hero-generated-image {
      display: block;
      width: 100%;
      object-fit: cover;
      object-position: center;
      border-radius: 22px;
      box-shadow: 0 12px 32px rgba(0, 38, 90, .16)
    }

    .hero-visual .float-pill {
      z-index: 2
    }

    .section-visual-image {
      overflow: hidden;
      border-radius: 22px;
      background: #eaf7ff
    }

    .section-visual-image img {
      display: block;
      width: 100%;
      height: 100%;
      min-height: 280px;
      max-height: 440px;
      aspect-ratio: 16/10;
      object-fit: cover;
      object-position: center;
      transition: transform .7s cubic-bezier(.2, .7, .2, 1)
    }

    .section-visual-panel:hover .section-visual-image img {
      transform: scale(1.035)
    }

    @media(max-width:760px) {
      .hero-visual {
        transform: none !important;
        margin-top: 12px
      }

      .hero-visual .hero-generated-image {
        height: auto;
        min-height: 220px;
        max-height: 330px;
        object-fit: cover
      }

      .section-visual-image img {
        min-height: 210px;
        max-height: 300px
      }
    }

    @media(prefers-reduced-motion:reduce) {
      .section-visual-image img {
        transition: none
      }
    }
  </style>

</head>

<body>
  <div aria-hidden="true" id="pageProgress"></div>
  <div aria-live="polite" class="site-loader" id="siteLoader" role="status">
    <div class="loader-inner"><img alt="Prudence Healthcare Growth Consultancy"
        src="{{asset('website')}}/assets/prudence-logo.png" />
      <div class="loader-track"><span></span></div><small>Preparing your growth experience</small>
    </div>
  </div>
  <div class="topline">
    <div class="wrap"><span>Healthcare Growth Consultancy</span><span>Integrated strategy • Smarter marketing •
        Measurable growth</span></div>
  </div>
  <header>
    <div class="nav"><a aria-label="Prudence home" class="brand" href="#home"><img
          alt="Prudence Healthcare Growth Consultancy" src="{{asset('website')}}/assets/prudence-logo.png" /></a><button
        aria-expanded="false" aria-label="Toggle navigation" class="menu" id="menuBtn">☰</button>
      <nav class="navlinks" id="navLinks"><a href="#overview">Overview</a><a href="#data-foundation">Marketing
          Strategy</a><a href="#crm">CRM</a><a href="#hybrid-network">Mobile Apps</a><a href="#journey-tools">Our
          Approach</a><a class="navbtn" href="{{ route('hospital.login') }}">Hospital Login ↗</a></nav>
    </div>
  </header>
  <main id="home">
    <section class="hero" data-section-motion="rise" id="overview">
      <div class="wrap hero-grid">
        <div><span class="eyebrow">Marketing Management Software (MMS)</span>
          <h1>Marketing Automation: <span>A Game Changer For Hybrid Marketing</span></h1>
          <div class="hero-actions"><a class="btn" href="#overview">Explore MMS <span>↗</span></a></div>
        </div>
        <div class="hero-visual">
          <img class="hero-generated-image" src="{{asset('website')}}/assets/hero-healthcare-network.webp"
            alt="Healthcare professionals connected through a digital marketing and analytics network" width="1600"
            height="900" fetchpriority="high" />
          <div class="float-pill"><span>WEB PORTAL • CRM • MOBILE APPS</span>Marketing Automation for Hybrid Healthcare
            Growth</div>
          <div class="float-pill"><span>WEB PORTAL • CRM • MOBILE APPS</span>Marketing Automation: A Game Changer For
            Hybrid Marketing</div>
        </div>
      </div>
    </section>
    <div class="trustbar">
      <div class="wrap trustrow">
        <div class="trustitem"><b>WEB PORTAL</b><small>WEB PORTAL</small></div>
        <div class="trustitem"><b>CRM</b><small>CRM</small></div>
        <div class="trustitem"><b>MOBILE APPS</b><small>MOBILE APPS</small></div>
        <div class="trustitem"><b>MARKETING AUTOMATION</b><small>MARKETING AUTOMATION</small></div>
      </div>
    </div>
    <section class="section soft note-section" data-section-motion="rise" id="data-foundation">
      <div class="wrap">
        <div class="section-head">
          <span class="eyebrow">Reasons to switch over automation</span>
          <h2>New Trends in Marketing</h2>
          <p>Build a connected marketing foundation around four data capabilities.</p>
        </div>
        <div class="note-grid four">
          <article class="note-card"><span class="note-index">01</span>
            <div class="note-icon">↗</div>
            <h3>Data Acquisition</h3>
            <p>Capture relevant audience, lead, customer and partner information across marketing channels.</p>
          </article>
          <article class="note-card"><span class="note-index">02</span>
            <div class="note-icon">▤</div>
            <h3>Data Warehousing</h3>
            <p>Bring collected information together in an organised, accessible data foundation.</p>
          </article>
          <article class="note-card"><span class="note-index">03</span>
            <div class="note-icon">⌕</div>
            <h3>Data Analysis</h3>
            <p>Study audience, campaign, engagement and conversion information to understand performance.</p>
          </article>
          <article class="note-card"><span class="note-index">04</span>
            <div class="note-icon">▥</div>
            <h3>Data Analytics</h3>
            <p>Turn organised data into reports, dashboards and actionable marketing insights.</p>
          </article>
        </div>
      </div>
    </section>
    <section class="section note-section" data-section-motion="slide-left" id="journey-tools">
      <div class="wrap">
        <div class="section-head">
          <span class="eyebrow">Journey designer · Marketing app</span>
          <h2>Tools &amp; Strategies</h2>
          <p>A practical mix of hybrid and digital marketing tools, supported by CRM and automation.</p>
        </div>
        <div class="section-visual-panel">
          <div class="section-visual-copy">
            <span class="visual-kicker">CONNECTED HEALTHCARE NETWORK</span>
            <h3>Relationship-led hybrid marketing</h3>
            <p>Bring healthcare professionals, partners and digital communication into one connected marketing journey.
            </p>
          </div>
          <div class="section-visual-image">
            <img alt="Relationship-led hybrid marketing" height="470" loading="lazy"
              src="{{asset('website')}}/assets/healthcare-team-network.webp" width="760" />
          </div>
        </div>
        <div class="strategy-layout">
          <div class="strategy-feature"><span class="strategy-label">Core approach</span>
            <h3>Hybrid Marketing</h3>
            <p>Connect relationship-led outreach and field activity with digital engagement and measurable campaigns.
            </p>
            <div class="strategy-divider"></div>
            <h3>Digital Marketing</h3>
            <p>Use online channels and digital campaigns to reach, engage and re-engage audiences.</p>
          </div>
          <div class="strategy-list">
            <div class="strategy-row"><span>01</span>
              <div>
                <h3>CRM Software</h3>
                <p>Manage contacts, leads, follow-ups and customer journeys.</p>
              </div>
            </div>
            <div class="strategy-row"><span>02</span>
              <div>
                <h3>WhatsApp Booster</h3>
                <p>Support direct communication and campaign outreach through WhatsApp.</p>
              </div>
            </div>
            <div class="strategy-row"><span>03</span>
              <div>
                <h3>Online Marketing</h3>
                <p>Coordinate digital promotion and audience engagement.</p>
              </div>
            </div>
            <div class="strategy-row"><span>04</span>
              <div>
                <h3>Training &amp; Monitoring</h3>
                <p>Support teams and monitor activity and performance.</p>
              </div>
            </div>
            <div class="strategy-row"><span>05</span>
              <div>
                <h3>Reports &amp; Analytics</h3>
                <p>Review campaign progress, lead movement and results.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section dark note-section" data-section-motion="zoom" id="hybrid-network">
      <div class="wrap">
        <div class="section-head light">
          <span class="eyebrow" style="color: rgb(0, 0, 0)">Hybrid marketing strategy</span>
          <h2>One Connected Marketing Network</h2>
          <p>Four focused mobile apps working around a central WhatsApp Booster.</p>
        </div>
        <div class="network-hub"><span>Central communication</span><strong>WhatsApp Booster</strong><small>Hybrid
            Marketing Strategy</small></div>
        <div class="network-grid">
          <article>
            <h3>Trade Marketing App</h3>
            <p>Connect medical students, clinic doctors, consultants and specialities.</p>
          </article>
          <article>
            <h3>Corporate Marketing App</h3>
            <p>Connect company categories, POS persons, employee groups and insurance / TPA details.</p>
          </article>
          <article>
            <h3>Internal Marketing App</h3>
            <p>Organise mobile contacts, near &amp; dear, local networks and social networks.</p>
          </article>
          <article>
            <h3>Freelancers Marketing App</h3>
            <p>Engage internships, POS businesses, influencers and affiliate marketers.</p>
          </article>
        </div>
      </div>
    </section>
    <section class="section soft note-section" data-section-motion="slide-right" id="audience-intelligence">
      <div class="wrap">
        <div class="section-head">
          <span class="eyebrow">Audience intelligence</span>
          <h2>Know Every Network. Understand Every Audience.</h2>
          <p>Capture the specific audience attributes and operational insights listed for each marketing app.</p>
        </div>
        <div class="audience-grid">
          <article class="audience-card">
            <h3>Trade Marketing</h3>
            <ul>
              <li>Medical students and clinic doctors</li>
              <li>Consultants and specialities</li>
              <li>Age, gender and degree</li>
              <li>Clinic analytics</li>
              <li>Location maps and communication</li>
            </ul>
          </article>
          <article class="audience-card">
            <h3>Corporate Marketing</h3>
            <ul>
              <li>Company category and POS persons</li>
              <li>Employee size</li>
              <li>Insurance / TPA and coverage premium</li>
              <li>Age, gender, DOB and contact details</li>
              <li>Insured dependents, locations and communication</li>
            </ul>
          </article>
          <article class="audience-card">
            <h3>Internal Marketing</h3>
            <ul>
              <li>Mobile contacts and near &amp; dear</li>
              <li>Local and social networks</li>
              <li>Age, gender and contact details</li>
              <li>Treatment category</li>
              <li>Location maps and communication</li>
            </ul>
          </article>
          <article class="audience-card">
            <h3>Freelancers Marketing</h3>
            <ul>
              <li>Internships and POS businesses</li>
              <li>Influencers and affiliate marketers</li>
              <li>Age, gender and DOB</li>
              <li>Mobile number and email</li>
              <li>Target audience and communication</li>
            </ul>
          </article>
        </div>
      </div>
    </section>
    <section class="section note-section" data-section-motion="clip" id="digital-healthcare">
      <div class="wrap">
        <div class="section-head">
          <span class="eyebrow">Digital marketing strategy</span>
          <h2>Targeted Campaigns &amp; Healthcare Offers</h2>
          <p>Use the channels and healthcare service categories from the planning notes to shape focused campaigns.</p>
        </div>
        <div class="section-visual-panel reverse">
          <div class="section-visual-copy">
            <span class="visual-kicker">DIGITAL CAMPAIGN EXPERIENCE</span>
            <h3>Reach the right audience</h3>
            <p>Present healthcare services and offers through coordinated digital channels and campaign communication.
            </p>
          </div>
          <div class="section-visual-image">
            <img alt="Reach the right audience" height="470" loading="lazy"
              src="{{asset('website')}}/assets/marketing-analytics.webp" width="760" />
          </div>
        </div>
        <div class="digital-grid">
          <article class="digital-card"><span class="digital-kicker">Digital channels</span>
            <h3>Reach the right audience</h3>
            <div class="tag-list"><span>AI-driven SEO</span><span>Social Media Ads</span><span>Native
                Ads</span><span>Display Ads</span><span>Video Ads</span><span>Retargeted Ads</span><span>Google
                Ads</span><span>Meta for Business</span><span>Pinterest Ads</span></div>
          </article>
          <article class="digital-card"><span class="digital-kicker">Limited-period offers</span>
            <h3>Healthcare services</h3>
            <div class="offer-list">
              <div><b>01</b><span>OP Doctor Consultations</span></div>
              <div><b>02</b><span>Minor Procedures</span></div>
              <div><b>03</b><span>Major Surgeries</span></div>
            </div>
          </article>
          <article class="digital-card"><span class="digital-kicker">Diagnostics &amp; wellness</span>
            <h3>Diagnostic Tests</h3>
            <div class="tag-list"><span>MRI Scan</span><span>CT Scan</span><span>Ultrasound</span><span>Digital
                X-Ray</span><span>2D Echo</span><span>ECG</span></div>
            <h3 class="subhead">Health Checkups</h3>
            <div class="tag-list">
              <span>Heart</span><span>Liver</span><span>Kidney</span><span>Lungs</span><span>Diabetic</span><span>Basic
                Health</span>
            </div>
          </article>
        </div>
      </div>
    </section>
    <section class="section soft note-section" data-section-motion="rise" id="data-reputation">
      <div class="wrap">
        <div class="section-head">
          <span class="eyebrow">Branding &amp; reputation building</span>
          <h2>One CRM. Unified Data Triggers.</h2>
          <p>Bring communication, customer data and reputation activities together through a central CRM framework.</p>
        </div>
        <div class="trigger-grid">
          <article><span>01</span>
            <h3>WhatsApp Booster</h3>
            <p>Coordinated WhatsApp communication.</p>
          </article>
          <article><span>02</span>
            <h3>Social Media Pages</h3>
            <p>Maintain connected social presence.</p>
          </article>
          <article><span>03</span>
            <h3>SMS Marketing</h3>
            <p>Deliver relevant SMS communication.</p>
          </article>
          <article><span>04</span>
            <h3>Email Marketing</h3>
            <p>Support email-based engagement.</p>
          </article>
        </div>
      </div>
    </section>
    <section class="section soft" data-section-motion="zoom" id="crm">
      <div class="wrap">
        <div class="section-head"><span class="eyebrow">A platform tailored for you</span>
          <h2>CRM &amp; Marketing Automation</h2>
          <p>The CRM platform capabilities listed in the Marketing Management Software presentation.</p>
        </div>
        <div class="section-visual-panel">
          <div class="section-visual-copy">
            <span class="visual-kicker">CRM &amp; ANALYTICS</span>
            <h3>Turn information into action</h3>
            <p>Bring lead tracking, follow-ups, dashboards and reporting into a clear, connected CRM workflow.</p>
          </div>
          <div class="section-visual-image">
            <img alt="Turn information into action" height="470" loading="lazy"
              src="{{asset('website')}}/assets/marketing-analytics.webp" width="760" />
          </div>
        </div>
        <div class="feature-grid">
          <div class="feature reveal">
            <div class="feature-icon">01</div>
            <div><b>API Integrations</b><small>Connected systems and workflows</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">02</div>
            <div><b>Real Time Dashboards</b><small>Live visibility</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">03</div>
            <div><b>Lead Campaigns</b><small>Campaign management</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">04</div>
            <div><b>Lead Customizations</b><small>Configurable lead journeys</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">05</div>
            <div><b>Contacts Management</b><small>Centralized contacts</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">06</div>
            <div><b>Reports and Analytics</b><small>Performance visibility</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">07</div>
            <div><b>Customized Web Meetings</b><small>Digital meetings</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">08</div>
            <div><b>Data Integration and Analysis</b><small>Unified data and analysis</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">09</div>
            <div><b>Social Media Management</b><small>Social channel management</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">10</div>
            <div><b>Marketing Mobile Apps</b><small>Mobile-first marketing</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">11</div>
            <div><b>CRM</b><small>Customer relationship management</small></div>
          </div>
          <div class="feature reveal">
            <div class="feature-icon">12</div>
            <div><b>MARKETING AUTOMATION</b><small>Hybrid marketing automation</small></div>
          </div>
        </div>
      </div>
    </section>
    <section class="section soft" data-section-motion="slide-left">
      <div class="wrap">
        <div class="section-head"><span class="eyebrow">Characteristics of actionable data</span>
          <h2>Accessibility, Accuracy &amp; Clarity</h2>
        </div>
        <div class="pillar-grid">
          <div class="pillar reveal">
            <div class="num">01</div>
            <h3>Accessibility</h3>
            <p>Access Management</p>
          </div>
          <div class="pillar reveal">
            <div class="num">02</div>
            <h3>Time Lines</h3>
            <p>Data Updation</p>
          </div>
          <div class="pillar reveal">
            <div class="num">03</div>
            <h3>Accuracy</h3>
            <p>Data Cleaning &amp; Validation</p>
          </div>
          <div class="pillar reveal">
            <div class="num">04</div>
            <h3>Clarity</h3>
            <p>Dashboarding</p>
          </div>
        </div>
        <div class="section-head" style="margin:42px auto 0">
          <h2>Actionable Data Benefits</h2>
          <p>Decision Making • Operational Efficiency • Continuous Improvement • Customer Retention • Privacy and
            Compliance</p>
        </div>
      </div>
    </section>
    <section class="cta" data-section-motion="slide-right" id="contact">
      <div class="contact-details">
        <div class="contact-detail"><span class="contact-symbol">☎</span>
          <div><small>CALL US</small><a aria-label="Call Prudence at +91 90001 70087" href="tel:+919000170087">+91
              90001 70087</a></div>
        </div>
        <div class="contact-detail"><span class="contact-symbol">✉</span>
          <div><small>EMAIL</small><a href="mailto:connect@ecaremanagers.com">connect@ecaremanagers.com</a></div>
        </div>
        <div class="contact-detail address-detail"><span class="contact-symbol">⌖</span>
          <div><small>OUR ADDRESS</small>
            <p><strong>Prudence</strong><br />H. No. 37-103/2, Madhura Nagar Colony,<br />Near Net X Roads,
              Malkajgiri,<br />Secunderabad, Telangana – 500056.</p>
          </div>
        </div>
        <div class="contact-detail whatsapp-detail">
          <span aria-hidden="true" class="contact-symbol whatsapp-symbol">
            <svg aria-hidden="true" fill="currentColor" height="21" viewbox="0 0 24 24" width="21">
              <path
                d="M20.52 3.48A11.83 11.83 0 0 0 12.08 0C5.5 0 .15 5.35.15 11.93c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.9 11.9 0 0 0 5.8 1.48h.01c6.58 0 11.93-5.35 11.93-11.93 0-3.19-1.24-6.19-3.49-8.43ZM12.08 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.72.97.99-3.63-.23-.37a9.86 9.86 0 0 1-1.52-5.25c0-5.46 4.44-9.9 9.9-9.9a9.83 9.83 0 0 1 7.01 2.9 9.83 9.83 0 0 1 2.9 7.01c0 5.46-4.44 9.9-9.9 9.9Zm5.43-7.41c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.21 5.08 4.5.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35Z">
              </path>
            </svg>
          </span>
          <div><small>WHATSAPP</small><a aria-label="Chat with Prudence on WhatsApp" href="https://wa.me/919000170087"
              rel="noopener noreferrer" target="_blank">Chat with us</a></div>
        </div>
      </div>
      <div class="wrap cta-inner">
        <div>
          <h2>THANK YOU</h2>
          <p>Digital Transformation In Hybrid Marketing</p>
        </div><a class="btn" href="#overview">Explore MMS ↗</a>
      </div>
    </section>
  </main>
  <footer>
    <div class="wrap">
      <div class="footer-grid">
        <div><img alt="Prudence Healthcare Growth Consultancy" class="footer-logo"
            src="{{asset('website')}}/assets/prudence-logo.png" />
          <p>Healthcare Growth Consultancy</p>
          <p>Marketing Management Software (MMS)<br />Marketing Automation: A Game Changer For Hybrid Marketing</p>
        </div>
        <div>
          <h4>Explore</h4><a href="#overview">Current Trends in Marketing</a><a href="#crm">CRM &amp; Marketing
            Automation</a><a href="#hybrid-network">Customised Mobile Apps</a>
        </div>
        <div>
          <h4>Presentation</h4><a href="#data-foundation">Full Presentation</a><a href="#contact">Thank You</a>
        </div>
        <div class="footer-contact">
          <h4>Contact Us</h4>
          <a aria-label="Call Prudence at +91 90001 70087" href="tel:+919000170087">+91 90001 70087</a>
          <a href="https://www.ecaremanagers.com" rel="noopener" target="_blank">www.ecaremanagers.com</a>
          <a href="mailto:connect@ecaremanagers.com">connect@ecaremanagers.com</a>
          <p>H. No. 37-103/2, Madhura Nagar Colony, Near Net X Roads, Malkajgiri, Secunderabad, Telangana – 500056.</p>
        </div>
      </div>
      <div class="footer-bottom"><span>© <span id="year"></span> Prudence. Healthcare Growth
          Consultancy.</span><span>Digital Transformation In Hybrid Marketing</span></div>
    </div>
  </footer>
  <script>
    (() => { const loader = document.getElementById('siteLoader'); const started = performance.now(); const hide = () => setTimeout(() => { loader?.classList.add('hide'); setTimeout(() => loader?.remove(), 750) }, Math.max(0, 650 - (performance.now() - started))); if (document.readyState === 'complete') hide(); else window.addEventListener('load', hide, { once: true }); setTimeout(hide, 4500); })();
    const menuBtn = document.getElementById('menuBtn'), navLinks = document.getElementById('navLinks'); menuBtn?.addEventListener('click', () => { const open = navLinks.classList.toggle('open'); menuBtn.setAttribute('aria-expanded', String(open)); menuBtn.textContent = open ? '×' : '☰' }); navLinks?.querySelectorAll('a').forEach(a => a.addEventListener('click', () => { navLinks.classList.remove('open'); menuBtn?.setAttribute('aria-expanded', 'false'); if (menuBtn) menuBtn.textContent = '☰' }));
    document.getElementById('year').textContent = new Date().getFullYear();
    const observer = new IntersectionObserver(entries => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target) } }), { threshold: .1 }); document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Section-wise cinematic motion: each section reveals with its own direction/effect.
    const sectionMotionObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const section = entry.target;
        section.classList.add('section-visible');
        section.querySelectorAll('.feature,.app-card,.pillar,.slide-card,.reference-tile,.metric')
          .forEach((item, index) => item.style.setProperty('--stagger', index % 8));
        observer.unobserve(section);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -7% 0px' });
    document.querySelectorAll('section[data-section-motion]').forEach(section => sectionMotionObserver.observe(section));


    // Lightweight page progress indicator; passive scroll listener keeps it smooth.
    (() => {
      const bar = document.getElementById('pageProgress');
      if (!bar) return;
      let ticking = false;
      const update = () => {
        const root = document.documentElement;
        const max = root.scrollHeight - root.clientHeight;
        const percent = max > 0 ? (root.scrollTop / max) * 100 : 0;
        bar.style.width = percent + '%';
        ticking = false;
      };
      window.addEventListener('scroll', () => { if (!ticking) { window.requestAnimationFrame(update); ticking = true; } }, { passive: true });
      update();
    })();

    // premiumCardStagger: stagger card entrances within each visible section.
    (() => {
      const groups = '.note-grid,.audience-grid,.digital-grid,.network-grid,.trigger-grid,.feature-grid,.pillar-grid,.metrics';
      const cards = '.note-card,.audience-card,.digital-card,.app-card,.pillar,.feature,.metric,.network-grid article,.trigger-grid article';
      document.querySelectorAll(groups).forEach(group => {
        [...group.querySelectorAll(cards)].forEach((card, i) => {
          card.style.setProperty('--card-order', i % 6);
          card.style.transitionDelay = `${(i % 6) * 75}ms`;
        });
      });
    })();
  </script>
  <div aria-label="Quick contact" class="quick-contact">
    <a aria-label="Call Prudence" class="quick-call" href="tel:+919000170087">
      <span class="quick-call-icon">☎</span><span>Call</span>
    </a>
    <a aria-label="Chat with Prudence on WhatsApp" class="quick-whatsapp" href="https://wa.me/919000170087"
      rel="noopener noreferrer" target="_blank">
      <svg aria-hidden="true" fill="currentColor" height="21" viewbox="0 0 24 24" width="21">
        <path
          d="M20.52 3.48A11.83 11.83 0 0 0 12.08 0C5.5 0 .15 5.35.15 11.93c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.9 11.9 0 0 0 5.8 1.48h.01c6.58 0 11.93-5.35 11.93-11.93 0-3.19-1.24-6.19-3.49-8.43ZM12.08 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.72.97.99-3.63-.23-.37a9.86 9.86 0 0 1-1.52-5.25c0-5.46 4.44-9.9 9.9-9.9a9.83 9.83 0 0 1 7.01 2.9 9.83 9.83 0 0 1 2.9 7.01c0 5.46-4.44 9.9-9.9 9.9Zm5.43-7.41c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.21 5.08 4.5.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35Z">
        </path>
      </svg>
      <span>WhatsApp</span>
    </a>
  </div>
</body>

</html>