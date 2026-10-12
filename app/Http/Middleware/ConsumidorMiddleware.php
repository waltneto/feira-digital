<?php

public function handle($request, Closure $next)
{
    if (!auth()->check() || !auth()->user()->isConsumidor()) {
        return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
    }
    
    return $next($request);
}
