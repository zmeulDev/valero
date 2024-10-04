import { readFileSync, writeFileSync } from 'fs';
import { resolve } from 'path';

const envFilePath = resolve(process.cwd(), '.env');
const envFileContent = readFileSync(envFilePath, 'utf8');

const newVersion = ` 0.${Math.floor(Date.now() / 1000) % 100000}`; // Shortened version to 5 digits

const updatedEnvFileContent = envFileContent.replace(/APP_VERSION=.*/, `APP_VERSION=${newVersion}`);

writeFileSync(envFilePath, updatedEnvFileContent, 'utf8');

console.log(`Updated APP_VERSION to ${newVersion}`);