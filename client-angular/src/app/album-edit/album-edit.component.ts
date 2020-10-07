import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';
import { FileUploader } from 'ng2-file-upload';

import { Config } from '../config';


@Component({
  selector: 'app-album-edit',
  templateUrl: './album-edit.component.html',
  styleUrls: ['./album-edit.component.scss']
})
export class AlbumEditComponent implements OnInit {

  private imageFieldName: string = "photo";

  albumName: string = "No name specified";
  albumDescription: string = "No description";
  photosList: string[] = [];
  
  uploader: FileUploader;
  uploadUrl = Config.apiUrl + '/uploadPhoto';
  response: string;
  selPhotoUrl: string;
  selPhotoName: string;

  deleting: boolean = false;
  settingCover: boolean = false;

  constructor(private route: ActivatedRoute,
              private photosManagerService: PhotosManagerService) { }


  private loadAlbumContent(name: string) {
    this.photosManagerService.getPhotosList(name).subscribe(
			(photosList: string[]) => {
				if (photosList == null) return;
				this.photosList = photosList.map( photoName => PhotosManagerService.getPhotoUrl(photoName))
			}
		);
  }

  ngOnInit() {
		this.albumName = decodeURI(this.route.snapshot.paramMap.get('name'));
    
    this.photosManagerService.getAlbumInfo(this.albumName).subscribe(
			(albumInfo: AlbumInfo) => this.albumDescription = albumInfo.description
		);

    this.loadAlbumContent(this.albumName);

    this.uploader = new FileUploader({
			url: this.uploadUrl,
      method: "POST",
      itemAlias: this.imageFieldName,
      additionalParameter: {
        'album': this.albumName
      },
		});

    this.uploader.response.subscribe(
			() => this.loadAlbumContent(this.albumName)
		);
  }

  onSelectPhoto(url: string) {
    // Store photo name in a local attribute, requesting zoom quality instead of cover
    this.selPhotoUrl= url;
    this.selPhotoName = PhotosManagerService.getPhotoNameFromUrl(this.selPhotoUrl);

    $('#photoModal').modal('show');
  }

  onDeletePhotoClick() {
    if (!this.selPhotoUrl) return;

    this.deleting = true;

    this.photosManagerService.deletePhoto(this.selPhotoUrl).subscribe(
			() => {
        this.loadAlbumContent(this.albumName)
        this.deleting = false;
        $('#photoModal').modal('hide');
			}
		);
  }

  onCoverPhotoClick() {
    if (!this.selPhotoUrl) return;

    this.settingCover = true;

    this.photosManagerService.setAlbumCover(this.albumName, this.selPhotoUrl).subscribe(
			() => {
        this.settingCover = false;
        $('#photoModal').modal('hide');
			}
		);
  }
}
