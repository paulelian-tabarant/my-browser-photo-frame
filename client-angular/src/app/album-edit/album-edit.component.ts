import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';
import { FileUploader } from 'ng2-file-upload';

import { Config } from '../config';

const uploadUrl = Config.apiUrl + '/uploadPhoto';

@Component({
  selector: 'app-album-edit',
  templateUrl: './album-edit.component.html',
  styleUrls: ['./album-edit.component.scss']
})
export class AlbumEditComponent implements OnInit {

  static coverQuality: number = 10;
  static zoomQuality: number = 100;

  private imageFieldName: string = "photo";

  albumName: string;
  albumDescription: string;
  photosList: string[];
  
  uploader: FileUploader;
  response: string;
  photoSelected: string;

  constructor(private route: ActivatedRoute,
              private photosManagerService: PhotosManagerService) { }


  private loadAlbumContent(name: string) {
    this.photosManagerService.getPhotosList(name, 10)
      .then((photosList: string[]) => { this.photosList = photosList; })
      .catch( /* do things here if necessary */);
  }

  ngOnInit() {
    this.albumName = this.route.snapshot.paramMap.get('name');
    
    this.photosManagerService.getAlbumInfo(this.albumName)
      .then((albumInfo: AlbumInfo) => { this.albumDescription = albumInfo.description; })
      .catch( /* do things here if necessary */ );

    this.loadAlbumContent(this.albumName);

    this.uploader = new FileUploader({
      url: uploadUrl,
      method: "POST",
      itemAlias: this.imageFieldName,
      additionalParameter: {
        'album': this.albumName
      },
    });

    this.uploader.response.subscribe(() => {
      this.loadAlbumContent(this.albumName)
    });
  }

  onSelectPhoto(srcPath: string) {
    let coverQ = AlbumEditComponent.coverQuality;
    let zoomQ = AlbumEditComponent.zoomQuality;

    // Store photo name in a local attribute, requesting zoom quality instead of cover
    this.photoSelected = srcPath.replace(`quality=${coverQ}`, `quality=${zoomQ}`);

    $('#photoModal').modal('show');
  }

  onDeletePhotoClick() {
    if (!this.photoSelected) return;

    this.photosManagerService.deletePhoto(this.photoSelected)
      .then(() => {
        this.loadAlbumContent(this.albumName)
        $('#photoModal').modal('hide');
      })
  }

  onCoverPhotoClick() {
    if (!this.photoSelected) return;

    this.photosManagerService.setAlbumCover(this.albumName, this.photoSelected)
      .then(() => {
        $('#photoModal').modal('hide');
      })
  }
}
