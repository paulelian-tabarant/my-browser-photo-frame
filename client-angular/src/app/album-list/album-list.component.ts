import { Component, OnInit, EventEmitter, Output } from '@angular/core';
import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';

@Component({
  selector: 'app-album-list',
  templateUrl: './album-list.component.html',
  styleUrls: ['./album-list.component.scss']
})
export class AlbumListComponent implements OnInit {

	// Attributes
  albumsList: AlbumInfo[] = new Array<AlbumInfo>();

  newAlbumTitle: string;
  newAlbumDescription: string;
  newAlbumPassword: string;
  newAlbumPasswordConfirm: string;
  passwordMismatch: boolean = false;

	// Methods
  constructor(
		private photosManagerService: PhotosManagerService,
	) { }

	@Output() editAlbum = new EventEmitter<string>();

	ngOnInit(): void
	{
		this.loadAlbums();
	}

	loadAlbums()
	{
    this.photosManagerService.getAlbumsList().subscribe(
			(albumsList: string[]) => {
				albumsList.forEach(album => {
					this.photosManagerService.getAlbumInfo(album).subscribe(
						(albumInfo: AlbumInfo) => {
							albumInfo.cover = PhotosManagerService.getPhotoUrl(albumInfo.cover);
							this.albumsList.push(albumInfo);
						});
				});
			}
		);
	}

  createNewAlbum() {
    if (this.newAlbumPassword != this.newAlbumPasswordConfirm) {
      this.passwordMismatch = true;
      return;
    }

    this.passwordMismatch = false;

    this.photosManagerService.createAlbum(
      this.newAlbumTitle,
      this.newAlbumDescription,
      this.newAlbumPassword).subscribe(
				() => {
					$("#newAlbumModal").modal('hide');
					this.onAlbumClick(this.newAlbumTitle);
				}
			);
	}

	onAlbumClick(name: string) {
		this.editAlbum.emit(name);
	}

	deleteAlbum(name: string) {
		this.photosManagerService.deleteAlbum(name).subscribe(
			() => this.loadAlbums(),
			(error) => console.log("Error while deleting album with name " + name)
		);
	}
}
