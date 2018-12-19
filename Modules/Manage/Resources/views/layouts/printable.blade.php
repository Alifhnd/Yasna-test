@extends('manage::layouts.plane')

<div class="print-{{ $size or 'A4-portrait' }}">
	{{ $slot }}
</div>

<script>window.print();</script>