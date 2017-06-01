import './scss/style';

declare const __IN_DEBUG__: boolean;

import { enableProdMode } from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';

import { AppModule } from './app/app.module';

if (!__IN_DEBUG__) {
  enableProdMode();
}

platformBrowserDynamic().bootstrapModule(AppModule);
