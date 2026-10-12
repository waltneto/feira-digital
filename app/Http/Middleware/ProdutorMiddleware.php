<?php

public function handle($request, Closure $next)
{
    if (!auth()->check() || !auth()->user()->isProdutor()) {
        return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
    }
    
    return $next($request);
}