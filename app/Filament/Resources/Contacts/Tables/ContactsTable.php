<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Models\Contact;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordAction(ViewAction::class)
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable()
                    ->weight(fn (Contact $record) => $record->is_read ? 'normal' : 'bold'),

                TextColumn::make('created_at')
                    ->label('Waktu Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->description(fn (Contact $record) => $record->created_at?->diffForHumans()),

                TextColumn::make('phone')
                    ->label('No. WhatsApp / HP')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('message')
                    ->label('Cuplikan Pesan')
                    ->limit(45)
                    ->tooltip(fn (Contact $record) => $record->message)
                    ->weight(fn (Contact $record) => $record->is_read ? 'normal' : 'medium'),

                TextColumn::make('is_read')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state) => $state ? 'Sudah Dilihat' : 'Belum Dilihat')
                    ->color(fn (bool $state) => $state ? 'gray' : 'danger')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Status Pesan')
                    ->placeholder('Semua Pesan')
                    ->trueLabel('Sudah Dilihat')
                    ->falseLabel('Belum Dilihat (Baru)'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat Pesan')
                    ->modalHeading(fn (Contact $record) => 'Detail Pesan: ' . $record->name)
                    ->beforeFormFilled(function (Contact $record) {
                        if (! $record->is_read) {
                            $record->markAsRead();
                        }
                    })
                    ->mutateRecordDataUsing(function (array $data, Contact $record): array {
                        if (! $record->is_read) {
                            $record->markAsRead();
                        }
                        $data['is_read'] = true;

                        return $data;
                    }),

                Action::make('markAsRead')
                    ->label('Tandai Dilihat')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Contact $record) => ! $record->is_read)
                    ->action(fn (Contact $record) => $record->markAsRead()),

                Action::make('markAsUnread')
                    ->label('Tandai Belum Dilihat')
                    ->icon('heroicon-o-envelope')
                    ->color('warning')
                    ->visible(fn (Contact $record) => $record->is_read)
                    ->action(fn (Contact $record) => $record->update(['is_read' => false])),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markAsRead')
                        ->label('Tandai Sudah Dilihat')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->markAsRead()),

                    BulkAction::make('markAsUnread')
                        ->label('Tandai Belum Dilihat')
                        ->icon('heroicon-o-envelope')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_read' => false])),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
